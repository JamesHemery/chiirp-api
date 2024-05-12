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
use App\Http\Controllers\Messages\ListMessagesController;
use App\Http\Controllers\Messages\ReadAudioMessageController;
use App\Http\Controllers\Messages\SendMessageController;
use App\Http\Controllers\SendLoginCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', LoginController::class);
    Route::post('login/send-code', SendLoginCodeController::class);
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::get('messages', ListMessagesController::class);
    Route::post('message/send', SendMessageController::class);
    Route::get('message/{message}/audio', ReadAudioMessageController::class);

    Route::get('account', ShowAccountController::class);
    Route::patch('account', UpdateAccountController::class);
    Route::delete('account', DeleteAccountController::class);
    Route::post('account/avatar', UpdateAvatarController::class);
    Route::post('account/public-key', UpdatePublicKeyController::class);

    Route::get('buddies', ListBuddiesController::class);
    Route::post('buddy', AddBuddyController::class);
    Route::delete('buddy/{buddy}', DeleteBuddyController::class);
});
