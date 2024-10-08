<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'agent_id', 'user_payment_id', 'amount', 'refrence_no', 'status', 'note', 'type', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userPayment()
    {
        return $this->belongsTo(UserPayment::class);
    }
}
