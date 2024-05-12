<?php

declare(strict_types=1);

use App\Http\Controllers\Account\DeleteAccountController;
use App\Http\Controllers\Account\ShowAccountController;
use App\Http\Controllers\Account\UpdateAccountController;
use App\Http\Controllers\Account\UpdateAvatarController;
use App\Http\Controllers\Account\UpdatePublicKeyController;
use App\Http\Controllers\Buddies\AddBuddyController;
use App\Http\Controllers\Buddies\DeleteBuddyController;
use App\Http\Controllers\Buddies\ListBuddiesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SendLoginCodeController;
use App\Http\Controllers\SendMessageController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', LoginController::class);
    Route::post('login/send-code', SendLoginCodeController::class);
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::post('messages', SendMessageController::class);

    Route::get('account', ShowAccountController::class);
    Route::patch('account', UpdateAccountController::class);
    Route::delete('account', DeleteAccountController::class);
    Route::post('account/avatar', UpdateAvatarController::class);
    Route::post('account/encryption-keys', UpdatePublicKeyController::class);

    Route::get('buddies', ListBuddiesController::class);
    Route::post('buddy', AddBuddyController::class);
    Route::delete('buddy/{buddy}', DeleteBuddyController::class);
});
