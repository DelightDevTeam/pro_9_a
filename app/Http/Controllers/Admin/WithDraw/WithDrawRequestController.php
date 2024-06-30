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

    public function show($id)
    {
        $withdraw = WithDrawRequest::find($id);

        return view('admin.withdraw_request.show', compact('withdraw'));
    }

    public function statusChange(Request $request, WithDrawRequest $withdraw)
    {

        $request->validate([
            'status' => 'required|in:0,1,2',
        ]);

        try {
            $agent = Auth::user();
            $player = User::find($request->player);
            if ($player->balanceFloat < $request->amount) {
                return redirect()->back()->with('error', 'The Player do not have enough balance to transfer!');
            }

            $withdraw->update([
                'status' => $request->status,
            ]);

            if ($request->status == 1) {
                app(WalletService::class)->transfer($player, $agent, $request->amount, TransactionName::DebitTransfer);
            }

            return back()->with('success', 'Withdraw Status changed successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
