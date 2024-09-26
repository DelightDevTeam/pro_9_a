<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_name' => $this->user_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'profile' => asset('assets/img/player_profile/'.$this->profile),
            'balance' => $this->balanceFloat,
            'status' => $this->status,
            'payment_type__id' => $this->payment_type_id,
            'payment_type' => $this->paymentType->name,
            'account_name' => $this->account_name,
            'account_no' => $this->account_no
        ];
    }
}
