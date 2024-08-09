<?php

namespace App\Http\Controllers\Api\V1\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DepositRequest as ApiDepositRequest;
use App\Models\DepositRequest;
use App\Traits\HttpResponses;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class DepositController extends Controller
{
    use HttpResponses;

    public function deposit(ApiDepositRequest $request)
    {
        try {
            $inputs = $request->validated();

            $player = Auth::user();

            $deposit = DepositRequest::create(array_merge(
                $inputs,
                [
                    'user_id' => $player->id,
                    'agent_id' => $player->agent_id,
                ]
            ));
            $secretKey = Config::get('scanner.secretKey');
            $token = Config::get('scanner.token');

            $param = [
                'agentId' => "TEST",
                'playerId' =>"TESt",
                'orderId' => '345433432',
                'bankAccount' => '34324324',
                'amount' => "100",
                'trxId' => "34534",
                'paymentType' => 'KBZ',
            ];

            $requestString = implode('|', $param);
            $encryptedData = $this->encrypt($requestString, $secretKey);

            $client = new Client();

            $response = $client->request('POST', 'https://mm-paydash.store/api/order', [
                'headers' => [
                    'token' => $token,
                ],
                'form_params' => $param,
            ]);
            $responseBody = json_decode($response->getBody(), true);
            if($response->getStatusCode() == 200 && $responseBody['result']['data']['isPassed'] == true){
                $deposit->update([
                    'status' => 1,
                    'type' => 'scanner'
                ]);
            }
            return $this->success($deposit, 'Deposit Request Success');
        } catch (Exception $e) {

            return $this->error('', $e->getMessage(), 401);
        }
    }

    private  function encrypt($data, $password)
    {
        $iv = substr(sha1(mt_rand()), 0, 16);
        $password = sha1($password);

        $salt = sha1(mt_rand());
        $saltWithPassword = hash('sha256', $password.$salt);

        $encrypted = openssl_encrypt("$data", 'aes-256-cbc', "$saltWithPassword", null, $iv);

        return $msgEncryptedBundle = "$iv:$salt:$encrypted";
    }
}
