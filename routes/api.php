<?php

declare(strict_types=1);

use App\Http\Controllers\Buddies\AddBuddyController;
use App\Http\Controllers\Buddies\DeleteBuddyController;
use App\Http\Controllers\Buddies\ListBuddiesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SendLoginCodeController;
use App\Http\Controllers\SendMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('login', LoginController::class);
    Route::post('login/send-code', SendLoginCodeController::class);
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::post('messages', SendMessageController::class);

    Route::get('buddies', ListBuddiesController::class);
    Route::post('buddy', AddBuddyController::class);
    Route::delete('buddy/{buddy}', DeleteBuddyController::class);
});
