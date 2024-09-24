<?php

namespace App\Http\Controllers\Api\V1\Player;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\UserPayment;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserPaymentControler extends Controller
{
    use HttpResponses;

    public function agentPayment()
    {
        $player = Auth::user();

        $data = UserPayment::with('paymentType')->where('user_id', $player->agent_id)->get();

        return $this->success($data, 'Agent Payment List');

    }

    public function paymentType()
    {
        $types = PaymentType::all();

        return $this->success($types, 'Payment Type List');
    }
}
