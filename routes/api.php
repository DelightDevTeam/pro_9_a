<?php

use App\Http\Controllers\Admin\BannerTextController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Bank\BankController;
use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\Game\GameController;
use App\Http\Controllers\Api\V1\Game\LaunchGameController;
use App\Http\Controllers\Api\V1\NewVersion\PlaceBetNewVersionController;
use App\Http\Controllers\Api\V1\PaymentType\PaymentTypeController;
use App\Http\Controllers\Api\V1\Player\DepositController;
use App\Http\Controllers\Api\V1\Player\PlayerTransactionLogController;
use App\Http\Controllers\Api\V1\Player\TransactionController;
use App\Http\Controllers\Api\V1\Player\UserPaymentControler;
use App\Http\Controllers\Api\V1\Player\WagerController;
use App\Http\Controllers\Api\V1\Player\WithDrawController;
use App\Http\Controllers\Api\V1\PromotionController;
use App\Http\Controllers\Api\V1\Webhook\BonusController;
use App\Http\Controllers\Api\V1\Webhook\BuyInController;
use App\Http\Controllers\Api\V1\Webhook\BuyOutController;
use App\Http\Controllers\Api\V1\Webhook\CancelBetController;
use App\Http\Controllers\Api\V1\Webhook\GameResultController;
use App\Http\Controllers\Api\V1\Webhook\GetBalanceController;
use App\Http\Controllers\Api\V1\Webhook\JackPotController;
use App\Http\Controllers\Api\V1\Webhook\MobileLoginController;
use App\Http\Controllers\Api\V1\Webhook\NewRedisPlaceBetController;
use App\Http\Controllers\Api\V1\Webhook\PlaceBetController;
use App\Http\Controllers\Api\V1\Webhook\PushBetController;
use App\Http\Controllers\Api\V1\Webhook\RollbackController;
use App\Http\Controllers\Api\V1\Webhook\VersionNewPlaceBetController;
use App\Http\Controllers\TestController;
use App\Models\Admin\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\NewVersion\NewBonusController;
use App\Http\Controllers\Api\V1\NewVersion\NewJackpotController;


//login route post
Route::post('/login', [AuthController::class, 'login']);

// logout
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('promotion', [PromotionController::class, 'index']);
Route::get('banner', [BannerController::class, 'index']);
Route::get('popup-ads-banner', [BannerController::class, 'AdsBannerIndex']);
Route::get('bannerText', [BannerController::class, 'bannerText']);
Route::get('v1/validate', [AuthController::class, 'callback']);
Route::get('gameTypeProducts/{id}', [GameController::class, 'gameTypeProducts']);
Route::get('allGameProducts', [GameController::class, 'allGameProducts']);
Route::get('gameType', [GameController::class, 'gameType']);
Route::get('gamelist/{product_id}/{game_type_id}', [GameController::class, 'gameList']);
Route::get('hotgamelist', [GameController::class, 'HotgameList']);
Route::post('Seamless/PullReport', [LaunchGameController::class, 'pullReport']);

Route::group(['prefix' => 'Seamless'], function () {
    Route::post('GetBalance', [GetBalanceController::class, 'getBalance']);

    // Route::group(["middleware" => ["webhook_log"]], function(){
    Route::post('GetGameList', [LaunchGameController::class, 'getGameList']);
    Route::post('GameResult', [GameResultController::class, 'gameResult']);
    Route::post('Rollback', [RollbackController::class, 'rollback']);
    //Route::post('PlaceBet', [PlaceBetController::class, 'placeBet']);
    //Route::post('PlaceBet', [NewRedisPlaceBetController::class, 'placeBetNew']);
    //Route::post('PlaceBet', [VersionNewPlaceBetController::class, 'placeBetNew']);
    Route::post('PlaceBet', [PlaceBetNewVersionController::class, 'placeBetNew']);

    Route::post('CancelBet', [CancelBetController::class, 'cancelBet']);
    Route::post('BuyIn', [BuyInController::class, 'buyIn']);
    Route::post('BuyOut', [BuyOutController::class, 'buyOut']);
    Route::post('PushBet', [PushBetController::class, 'pushBet']);
    //Route::post('Bonus', [BonusController::class, 'bonus']);
    Route::post('Bonus', [NewBonusController::class, 'bonus']);
    //Route::post('Jackpot', [JackPotController::class, 'jackPot']);
    Route::post('Jackpot', [NewJackpotController::class, 'jackPot']);
    Route::post('MobileLogin', [MobileLoginController::class, 'MobileLogin']);
    // });
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('wager-logs', [WagerController::class, 'index']);
    Route::get('transactions', [TransactionController::class, 'index']);

    //logout
    Route::get('user', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    Route::post('profile', [AuthController::class, 'profile']);
    Route::get('agent-payment-type', [UserPaymentControler::class, 'agentPayment']);
    Route::get('payment-type', [UserPaymentControler::class, 'paymentType']);
    Route::get('contact', [ContactController::class, 'index']);

    Route::group(['prefix' => 'transaction'], function () {
        Route::post('withdraw', [WithDrawController::class, 'withdraw']);
        Route::post('deposit', [DepositController::class, 'deposit']);
        Route::get('player-transactionlog', [PlayerTransactionLogController::class, 'index']);
        Route::get('deposit-requestlog', [TransactionController::class, 'depositRequestLog']);
        Route::get('withdraw-requestlog', [TransactionController::class, 'withDrawRequestLog']);
    });

    Route::group(['prefix' => 'bank'], function () {
        Route::get('all', [BankController::class, 'all']);
    });
    Route::group(['prefix' => 'game'], function () {
        Route::post('Seamless/LaunchGame', [LaunchGameController::class, 'launchGame']);
    });
    Route::group(['prefix' => 'direct'], function () {
        Route::post('Seamless/LaunchGame', [LaunchGameController::class, 'directLaunchGame']);
    });
});

Route::get('/game/gamelist/{provider_id}/{game_type_id}', [GameController::class, 'gameList']);