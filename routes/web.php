<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

require_once __DIR__.'/admin.php';

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

//auth routes
Route::get('/login', [LoginController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('get-change-password', [LoginController::class, 'changePassword'])->name('getChangePassword');
Route::post('update-password/{user}', [LoginController::class, 'updatePassword'])->name('updatePassword');

Route::get('/test-redis', function () {
    // Store a value in Redis for 10 minutes (600 seconds)
    Cache::store('redis')->put('key', 'value', 600);

    // Retrieve the stored value
    $value = Cache::store('redis')->get('key');

    // Dump and die (dd) to output the value
    dd($value); // Should output: "value"
});
