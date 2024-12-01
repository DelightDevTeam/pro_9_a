<?php

namespace App\Http\Controllers\Api\V1\NewVersion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slot\BonuSlotWebhookRequest;
use App\Services\Slot\SlotWebhookService;
use App\Enums\SlotWebhookResponseCode;
use App\Enums\TransactionName;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\V1\Webhook\Traits\BonuUseWebhook;
use App\Models\User;

class NewJackpotController extends Controller
{
    use BonuUseWebhook;

    public function jackpot(BonuSlotWebhookRequest $request)
    {
        $userId = $request->getMember()->id;

        // Retry logic for acquiring the Redis lock
        $attempts = 0;
        $maxAttempts = 3;
        $lock = false;

        while ($attempts < $maxAttempts && !$lock) {
            $lock = Redis::set("wallet:lock:$userId", true, 'EX', 15, 'NX'); // 15 seconds lock
            $attempts++;

            if (!$lock) {
                sleep(1); // Wait for 1 second before retrying
            }
        }

        if (!$lock) {
            return response()->json([
                'message' => 'Another transaction is currently processing. Please try again later.',
                'userId' => $userId,
            ], 409); // 409 Conflict
        }

        // Validate the structure of the request
        $validator = $request->check();

        if ($validator->fails()) {
            // Release Redis lock and return validation error response
            Redis::del("wallet:lock:$userId");
            return $validator->getResponse();
        }

        // Retrieve transactions from the request
        $transactions = $validator->getRequestTransactions();

        if (!is_array($transactions) || empty($transactions)) {
            Redis::del("wallet:lock:$userId");

            return response()->json([
                'message' => 'Invalid transaction data format.',
                'details' => $transactions,
            ], 400); // 400 Bad Request
        }

        $before_balance = $request->getMember()->balanceFloat;
            $event = $this->createEvent($request);

        DB::beginTransaction();

        try {
            // Create an event for the jackpot transactions
            //$event = $this->createEvent($request);

            // Process the transactions and create wagers
            $seamless_transactions = $this->createWagerTransactions($transactions, $event);

            // Transfer jackpot amounts to the player
            foreach ($seamless_transactions as $seamless_transaction) {
                $this->processTransfer(
                    User::adminUser(),                     // From Admin/System wallet
                    $request->getMember(),                 // To Player wallet
                    TransactionName::JackPot,              // Transaction type: Jackpot
                    $seamless_transaction->transaction_amount,
                    $seamless_transaction->rate,
                    [
                        'wager_id' => $seamless_transaction->wager_id,
                        'event_id' => $request->getMessageID(),
                        'seamless_transaction_id' => $seamless_transaction->id,
                    ]
                );
            }

            DB::commit();

            // Refresh the player's wallet balance
            $request->getMember()->wallet->refreshBalance();
            $after_balance = $request->getMember()->balanceFloat;

        } catch (\Exception $e) {
            DB::rollBack();
            Redis::del("wallet:lock:$userId");

            Log::error('Error during jackpot processing', ['error' => $e]);
            return response()->json(['message' => $e->getMessage()], 500);
        }

        // Release the Redis lock
        Redis::del("wallet:lock:$userId");

        // Return success response
        return SlotWebhookService::buildResponse(
            SlotWebhookResponseCode::Success,
            $after_balance,
            $before_balance
        );
    }
}