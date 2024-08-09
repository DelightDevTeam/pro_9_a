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
    public function index()
    {
        $this->authorize('transfer_log', User::class);

        $transferLogs = Auth::user()->transactions()->with('targetUser')
            ->whereIn('transactions.type', ['withdraw', 'deposit'])
            ->whereIn('transactions.name', ['credit_transfer', 'debit_transfer'])
            ->latest()->paginate();

        return view('admin.trans_log.index', compact('transferLogs'));
    }
}
