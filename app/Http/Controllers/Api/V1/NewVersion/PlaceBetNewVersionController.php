<?php

namespace App\Http\Controllers\Api\V1\NewVersion;

use App\Enums\SlotWebhookResponseCode;
use App\Enums\TransactionName;
use App\Http\Controllers\Api\V1\Webhook\Traits\NewVersionOptimizedBettingProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\Slot\SlotWebhookRequest;
use App\Models\User;
use App\Services\Slot\SlotWebhookService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class PlaceBetNewVersionController extends Controller
{
    use NewVersionOptimizedBettingProcess;

    public function placeBetNew(SlotWebhookRequest $request)
    {
        $userId = $request->getMember()->id;

        // Retry logic for acquiring the Redis lock
        $attempts = 0;
        $maxAttempts = 3;
        $lock = false;

        while ($attempts < $maxAttempts && ! $lock) {
            $lock = Redis::set("wallet:lock:$userId", true, 'EX', 15, 'NX'); // 15 seconds lock
            $attempts++;

            if (! $lock) {
                sleep(1); // Wait for 1 second before retrying
            }
        }

        if (! $lock) {
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

        // Check if the transactions are in the expected format
        if (! is_array($transactions) || empty($transactions)) {
            Redis::del("wallet:lock:$userId");

            return response()->json([
                'message' => 'Invalid transaction data format.',
                'details' => $transactions,  // Provide details about the received data for debugging
            ], 400);  // 400 Bad Request
        }

        // Read operations (happens outside the transaction)
        $before_balance = $request->getMember()->balanceFloat;

        $event = $this->createEvent($request);

        DB::beginTransaction();
        try {
            // Create and store the event in the database
            //$event = $this->createEvent($request);

            // Insert bets using chunking for better performance
            $message = $this->insertBets($transactions, $event);  // Insert bets in chunks

            DB::commit();  // Commit only the bet insertion

        } catch (\Exception $e) {
            DB::rollBack();
            Redis::del("wallet:lock:$userId");
            Log::error('Error during placeBet', ['error' => $e]);

            return response()->json(['message' => $e->getMessage()], 500);
        }

        // After the transaction, handle the wallet updates separately
        try {
            foreach ($transactions as $transaction) {
                // Assuming 'from' user is the one placing the bet and 'to' is the admin or system wallet
                $fromUser = $request->getMember();
                $toUser = User::adminUser();  // Admin or central system wallet

                $meta = [
                    'wager_id' => $transaction->WagerID,               // Use object property access
                    'event_id' => $request->getMessageID(),
                    'seamless_transaction_id' => $transaction->TransactionID,  // Use object property access
                ];

                // Call processTransfer for each transaction
                $this->processTransfer(
                    $fromUser,                        // From user
                    $toUser,                          // To user (admin/system wallet)
                    TransactionName::Stake,           // Transaction name (e.g., Stake)
                    $transaction->TransactionAmount,  // Use object property access for TransactionAmount
                    $transaction->Rate,               // Use object property access for Rate
                    $meta                             // Meta data (wager id, event id, etc.)
                );
            }

            // Refresh balance after transactions
            $request->getMember()->wallet->refreshBalance();
            $after_balance = $request->getMember()->balanceFloat;

        } catch (\Exception $e) {
            Log::error('Error during wallet transfer processing', ['error' => $e]);
            Redis::del("wallet:lock:$userId");

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
