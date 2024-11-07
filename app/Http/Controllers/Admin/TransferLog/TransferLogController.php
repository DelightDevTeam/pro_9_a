<?php

namespace App\Http\Controllers\Admin\TransferLog;

use App\Http\Controllers\Controller;
use App\Models\Admin\TransferLog;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferLogController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('transfer_log', User::class);

        $transferLogs = Auth::user()->transactions()->with('targetUser')
            ->whereIn('transactions.type', ['withdraw', 'deposit'])
            ->whereIn('transactions.name', ['credit_transfer', 'debit_transfer'])
            ->when(isset($request->type), function ($query) use ($request) {
                $query->where('transactions.type', $request->type);
            })
            ->when(isset($request->start_date) && isset($request->end_date), function ($query) use ($request) {
                $query->whereBetween('transactions.created_at', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
            })
            ->latest()->paginate();

        return view('admin.trans_log.index', compact('transferLogs'));
    }
}
