<?php

namespace App\Http\Controllers\Admin\Deposit;

use App\Enums\TransactionName;
use App\Http\Controllers\Controller;
use App\Models\DepositRequest;
use App\Models\User;
use App\Models\UserPayment;
use App\Services\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositRequestController extends Controller
{
    public function index(Request $request)
    {
        $deposits = DepositRequest::with(['user', 'userPayment'])
            ->where('agent_id', Auth::id())
            ->when($request->filled('status') && $request->input('status') !== 'all', function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->when(isset($request->player_id), function ($query) use ($request) {
                $query->where('user_id', $request->player_id);
            })
            ->when(isset($request->user_payment_id), function ($query) use ($request) {
                $query->where('user_payment_id', $request->user_payment_id);
            })
            ->when(isset($request->start_date) && isset($request->end_date), function ($query) use ($request) {
                $query->whereBetween('created_at',[$request->start_date . ' 00:00:00' , $request->end_date . ' 23:59:59']);
            })
            ->orderBy('id', 'desc')
            ->get();

        $paymentTypes = UserPayment::with('paymentType')->where('user_id', Auth::id())->get();

        return view('admin.deposit_request.index', compact('deposits', 'paymentTypes'));
    }

    public function statusChangeIndex(Request $request, DepositRequest $deposit)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
            'amount' => 'required|numeric|min:0',
            'player' => 'required|exists:users,id',
        ]);

        try {
            $agent = Auth::user();
            $player = User::find($request->player);

            // Check if the status is being approved and balance is sufficient
            if ($request->status == 1 && $agent->balanceFloat < $request->amount) {
                return redirect()->back()->with('error', 'You do not have enough balance to transfer!');
            }

            // Update the deposit status
            $deposit->update([
                'status' => $request->status,
            ]);

            // Transfer the amount if the status is approved
            if ($request->status == 1) {
                app(WalletService::class)->transfer($agent, $player, $request->amount, TransactionName::DebitTransfer);
            }

            return redirect()->route('admin.agent.deposit')->with('success', 'Deposit status updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function statusChangeReject(Request $request, DepositRequest $deposit)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);

        try {
            // Update the deposit status
            $deposit->update([
                'status' => $request->status,
            ]);

            return redirect()->route('admin.agent.deposit')->with('success', 'Deposit status updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public  function show(DepositRequest $deposit)
    {
        return view('admin.deposit_request.show', compact('deposit'));
    }
}
