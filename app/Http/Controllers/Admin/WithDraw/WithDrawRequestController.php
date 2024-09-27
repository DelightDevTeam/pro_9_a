<?php

namespace App\Http\Controllers\Admin\WithDraw;

use App\Enums\TransactionName;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithDrawRequest;
use App\Services\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithDrawRequestController extends Controller
{
    public function index()
    {
        $withdraws = WithDrawRequest::with(['user', 'paymentType'])->get();

        return view('admin.withdraw_request.index', compact('withdraws'));
    }

    public function statusChangeIndex(Request $request, WithDrawRequest $withdraw)
    {
        $request->validate([
            'status' => 'required|in:0,1',
            'amount' => 'required|numeric|min:0',
            'player' => 'required|exists:users,id',
        ]);

        try {
            $agent = Auth::user();
            $player = User::find($request->player);

            if ($request->status == 1 && $agent->balanceFloat < $request->amount || $player->balanceFloat < $request->amount) {
                return redirect()->route('admin.agent.withdraw')->with('error', 'You do not have enough balance to transfer!'); 
            }
           
            $withdraw->update([
                'status' => $request->status,
            ]);

            if ($request->status == 1) {
                app(WalletService::class)->transfer($player, $agent, $request->amount, TransactionName::DebitTransfer);
            }

            return redirect()->route('admin.agent.withdraw')->with('success', 'Withdraw status updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function statusChangeReject(Request $request, WithDrawRequest $withdraw)
    {
        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);

        try {
            $withdraw->update([
                'status' => $request->status,
            ]);

            return redirect()->route('admin.agent.withdraw')->with('success', 'Withdraw status updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
