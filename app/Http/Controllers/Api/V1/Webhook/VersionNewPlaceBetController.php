<?php

namespace App\Http\Controllers\Api\V1\Webhook;

use App\Models\User;
use App\Enums\TransactionName;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Enums\SlotWebhookResponseCode;
use App\Services\Slot\SlotWebhookService;
use App\Http\Requests\Slot\SlotWebhookRequest;
use App\Http\Controllers\Api\V1\Webhook\Traits\OptimizedBettingProcess;

class VersionNewPlaceBetController extends Controller
{
    use OptimizedBettingProcess;

    public function placeBetNew(SlotWebhookRequest $request)
    {
        $userId = $request->getMember()->id;

        // Try to acquire a Redis lock for the user's wallet
        $lock = Redis::set("wallet:lock:$userId", true, 'EX', 10, 'NX'); // 10 seconds lock
        if (!$lock) {
            return response()->json([
                'message' => 'The wallet is currently being updated. Please try again later.',
            ], 409); // 409 Conflict
        }

        $validator = $request->check();

        if ($validator->fails()) {
            // Release Redis lock and return validation error response
            Redis::del("wallet:lock:$userId");
            return $validator->getResponse();
        }

        $before_balance = $request->getMember()->balanceFloat;

        DB::beginTransaction();
        try {
            // Create and store the event in the database
            $event = $this->createEvent($request);

            // Create wager transactions related to the event
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

            // Return success response
            return SlotWebhookService::buildResponse(
                SlotWebhookResponseCode::Success,
                $after_balance,
                $before_balance
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Redis::del("wallet:lock:$userId");
            Log::error('Error during placeBet', ['error' => $e]);

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}