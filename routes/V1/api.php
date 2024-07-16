<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'signUp']);
Route::post('login', [AuthController::class, 'signIn']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('resend-otp', [AuthController::class, 'resendOtp']);
Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);


Route::group(['middleware' => ['auth:sanctum', 'verified']], function ($auth) {
    $auth->post('logout', [AuthController::class, 'logOut']);
    $auth->get('get-user', [AuthController::class, 'getUser']);
});
