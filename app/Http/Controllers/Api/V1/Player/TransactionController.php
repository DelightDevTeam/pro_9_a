<?php

namespace App\Http\Controllers\Api\V1\Player;

use App\Enums\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\SeamlessTransactionResource;
use App\Http\Resources\TransactionResource;
use App\Models\DepositRequest;
use App\Models\SeamlessTransaction;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithDrawRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use HttpResponses;

    public function index(Request $request)
    {
        $type = $request->get('type');

        [$from, $to] = match ($type) {
            'yesterday' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()],
            'this_week' => [now()->startOfWeek(), now()->endOfWeek()],
            'last_week' => [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()],
            default => [now()->startOfDay(), now()],
        };

        $user = auth()->user();

        $transactions = $user->transactions()->with(['seamlessTransaction.product:id,name'])->whereBetween('created_at', [$from, $to])
            ->orderBy('id', 'DESC')
            ->paginate();

        // return $this->success($transactions);
        return $this->success(TransactionResource::collection($transactions));
    }

    public function depositRequestLog()
    {
        $transactions = DepositRequest::with('user')->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->paginate();

        return $this->success($transactions);
    }

    public function withDrawRequestLog()
    {
        $transactions = WithDrawRequest::with('user')->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->paginate();

        return $this->success($transactions);
    }
}
