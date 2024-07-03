<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    use HttpResponses;
    private const ADMIN_ID = 1;

    public function index()
    {
        $player = Auth::user();
        if($player){
            $contact = Contact::where('user_id', $player->agent_id)->latest()->first();
        }else{
            $contact = Contact::where('user_id',self::ADMIN_ID)->latest()->first();
        }
        
        return $this->success($contact);
    }

}
