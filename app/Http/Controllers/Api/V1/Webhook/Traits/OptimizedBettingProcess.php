<?php

namespace App\Http\Controllers\Api\V1\Webhook\Traits;

use App\Enums\TransactionName;
use App\Enums\WagerStatus;
use App\Http\Requests\Slot\SlotWebhookRequest;
use App\Models\Admin\GameType;
use App\Models\Admin\GameTypeProduct;
use App\Models\Admin\Product;
use App\Models\SeamlessEvent;
use App\Models\User;
use App\Models\Wager;
use App\Services\WalletService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

trait OptimizedBettingProcess
{
    public function placeBet(SlotWebhookRequest $request)
    {
        $userId = $request->getMember()->id;

        // Try to acquire a Redis lock for the user's wallet
        $lock = Redis::set("wallet:lock:$userId", true, 'EX', 10, 'NX');  // 10-second lock

        if (! $lock) {
            return response()->json(['message' => 'The wallet is currently being updated. Please try again later.'], 409);
        }

        DB::beginTransaction();
        try {
            // Validate the request
            $validator = $request->check();
            if ($validator->fails()) {
                Redis::del("wallet:lock:$userId");

                return $validator->getResponse();
            }

            $before_balance = $request->getMember()->balanceFloat;

            // Create and store the event in the database
            $event = $this->createEvent($request);

            // Create wager transactions
            $seamless_transactions = $this->createWagerTransactions($validator->getRequestTransactions(), $event);

            // Process each seamless transaction
            foreach ($seamless_transactions as $seamless_transaction) {
                $this->processTransfer(
                    $request->getMember(),
                    User::adminUser(),
                    TransactionName::Stake,
                    $seamless_transaction->transaction_amount,
                    $seamless_transaction->rate,
                    [
                        'wager_id' => $seamless_transaction->wager_id,
                        'event_id' => $request->getMessageID(),
                        'seamless_transaction_id' => $seamless_transaction->id,
                    ]
                );
            }

            // Refresh balance after transactions
            $request->getMember()->wallet->refreshBalance();
            $after_balance = $request->getMember()->balanceFloat;

            DB::commit();
            Redis::del("wallet:lock:$userId");

            return response()->json([
                'balance_before' => $before_balance,
                'balance_after' => $after_balance,
                'message' => 'Bet placed successfully.',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Redis::del("wallet:lock:$userId");

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Create seamless transactions and handle deadlock retries.
     */
    public function createWagerTransactions($requestTransactions, SeamlessEvent $event, bool $refund = false)
    {
        $seamless_transactions = [];
        $retryCount = 0;
        $maxRetries = 5;

        foreach ($requestTransactions as $requestTransaction) {
            do {
                try {
                    DB::transaction(function () use (&$seamless_transactions, $event, $requestTransaction, $refund) {
                        // Fetch wager with lock
                        $wager = Wager::where('seamless_wager_id', $requestTransaction->WagerID)
                            ->lockForUpdate()
                            ->firstOrCreate([
                                'user_id' => $event->user_id,
                                'seamless_wager_id' => $requestTransaction->WagerID,
                            ]);

                        // Update wager status
                        if ($refund) {
                            $wager->update(['status' => WagerStatus::Refund]);
                        } elseif (! $wager->wasRecentlyCreated) {
                            $wager->update(['status' => $requestTransaction->TransactionAmount > 0 ? WagerStatus::Win : WagerStatus::Lose]);
                        }

                        // Retrieve game type and product
                        $game_type = GameType::where('code', $requestTransaction->GameType)->firstOrFail();
                        $product = Product::where('code', $requestTransaction->ProductID)->firstOrFail();
                        $rate = GameTypeProduct::where('game_type_id', $game_type->id)
                            ->where('product_id', $product->id)
                            ->firstOrFail()->rate;

                        // Create seamless transaction
                        $seamless_transactions[] = $event->transactions()->create([
                            'user_id' => $event->user_id,
                            'wager_id' => $wager->id,
                            'game_type_id' => $game_type->id,
                            'product_id' => $product->id,
                            'seamless_transaction_id' => $requestTransaction->TransactionID,
                            'rate' => $rate,
                            'transaction_amount' => $requestTransaction->TransactionAmount,
                            'bet_amount' => $requestTransaction->BetAmount,
                            'valid_amount' => $requestTransaction->ValidBetAmount,
                            'status' => $requestTransaction->Status,
                        ]);
                    });

                    break;  // Exit loop if successful
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() === '40001') {  // Deadlock error code
                        $retryCount++;
                        if ($retryCount >= $maxRetries) {
                            throw $e;  // Max retries reached, fail
                        }
                        sleep(1);  // Wait before retrying
                    } else {
                        throw $e;  // Rethrow non-deadlock exceptions
                    }
                }
            } while ($retryCount < $maxRetries);
        }

        return $seamless_transactions;
    }

    /**
     * Process the wallet transfer, handling deadlock retries.
     */
    public function processTransfer(User $from, User $to, TransactionName $transactionName, float $amount, int $rate, array $meta)
    {
        $retryCount = 0;
        $maxRetries = 5;

        do {
            try {
                DB::transaction(function () use ($from, $to, $amount, $transactionName, $meta) {
                    // Fetch the wallet and lock it for update
                    $wallet = $from->wallet()->lockForUpdate()->firstOrFail();

                    // Ensure the version matches for optimistic locking
                    if ($wallet->version !== $from->wallet->version) {
                        throw new \Exception('Version mismatch detected.');
                    }

                    // Update wallet balance
                    $wallet->balance -= $amount;

                    // Increment the version column
                    $wallet->version += 1;

                    // Save the changes to the wallet
                    $wallet->save();

                    // Perform the transfer
                    app(WalletService::class)->transfer($from, $to, abs($amount), $transactionName, $meta);
                });

                break;  // Exit loop if successful
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() === '40001') {  // Deadlock error code
                    $retryCount++;
                    if ($retryCount >= $maxRetries) {
                        throw $e;  // Max retries reached, fail
                    }
                    sleep(1);  // Wait before retrying
                } else {
                    throw $e;  // Rethrow non-deadlock exceptions
                }
            }
        } while ($retryCount < $maxRetries);
    }

    // public function processTransfer(User $from, User $to, TransactionName $transactionName, float $amount, int $rate, array $meta)
    // {
    //     $retryCount = 0;
    //     $maxRetries = 5;

    //     do {
    //         try {
    //             DB::transaction(function () use ($from, $to, $amount, $transactionName, $meta) {
    //                 app(WalletService::class)->transfer($from, $to, abs($amount), $transactionName, $meta);
    //             });

    //             break;  // Exit loop if successful
    //         } catch (\Illuminate\Database\QueryException $e) {
    //             if ($e->getCode() === '40001') {  // Deadlock error code
    //                 $retryCount++;
    //                 if ($retryCount >= $maxRetries) {
    //                     throw $e;  // Max retries reached, fail
    //                 }
    //                 sleep(1);  // Wait before retrying
    //             } else {
    //                 throw $e;  // Rethrow non-deadlock exceptions
    //             }
    //         }
    //     } while ($retryCount < $maxRetries);
    // }

    /**
     * Create the event in the system.
     */
    public function createEvent(SlotWebhookRequest $request): SeamlessEvent
    {
        return SeamlessEvent::create([
            'user_id' => $request->getMember()->id,
            'message_id' => $request->getMessageID(),
            'product_id' => $request->getProductID(),
            'request_time' => $request->getRequestTime(),
            'raw_data' => $request->all(),
        ]);
    }
}
