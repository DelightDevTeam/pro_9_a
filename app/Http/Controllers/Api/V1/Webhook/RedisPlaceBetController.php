<?php

namespace App\Http\Controllers\Api\V1\Webhook;

use Illuminate\Support\Facades\Redis;
use App\Enums\SlotWebhookResponseCode;
use App\Enums\TransactionName;
use App\Http\Controllers\Controller;
use App\Http\Requests\Slot\SlotWebhookRequest;
use App\Services\Slot\SlotWebhookService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\V1\Webhook\Traits\RedisUseWebhook;
use App\Models\User;

class RedisPlaceBetController extends Controller
{
    use RedisUseWebhook;

    public function placeBet(SlotWebhookRequest $request)
    {
        DB::beginTransaction();
        try {
            $validator = $request->check();

            if ($validator->fails()) {
                return $validator->getResponse();
            }

            $before_balance = $request->getMember()->balanceFloat;

            // Cache event in Redis before processing
            $ttl = 600; // Time-to-live for Redis cache (in seconds)
            Redis::setex('event:' . $request->getMessageID(), $ttl, json_encode($request->all()));

            // Log the event being cached
            Log::info('Event cached in Redis', ['key' => 'event:' . $request->getMessageID(), 'value' => json_encode($request->all())]);

            // Retrieve cached data from Redis
            $cachedData = Redis::get('event:' . $request->getMessageID());
            Log::info('Redis get event', ['cachedData' => $cachedData]);

            // Convert cached data back to array
            $cachedDataArray = json_decode($cachedData, true);

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

            // Return success response
            return SlotWebhookService::buildResponse(
                SlotWebhookResponseCode::Success,
                $after_balance,
                $before_balance
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during placeBet', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}