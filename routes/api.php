<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Api\v1'], function ($api) {
    $api->post('register', 'AuthController@signUp');
    $api->post('login', 'AuthController@signIn');
    $api->post('forgot-password', 'AuthController@forgotPassword');
    $api->post('resend-otp', 'AuthController@resendOtp');
    $api->post('verify-otp', 'AuthController@verifyOtp');
    $api->post('reset-password', 'AuthController@resetPassword');

    Route::group(['middleware' => ['auth:sanctum', 'verified']], function ($auth) {
        $auth->post('logout', 'AuthController@logOut');
        $auth->get('get-user', 'AuthController@getUser');
    });
});
