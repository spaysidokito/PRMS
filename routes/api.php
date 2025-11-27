<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/password/send-code', [App\Http\Controllers\EmailJsPasswordResetController::class, 'sendResetCode']);
Route::post('/password/verify-reset', [App\Http\Controllers\EmailJsPasswordResetController::class, 'verifyCodeAndReset']);
