<?php

declare(strict_types=1);

use App\Http\Controllers\SendMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::post('messages', SendMessageController::class);
});