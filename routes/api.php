<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Api\v1'], function ($api) {
    $api->post('register', 'AuthController@signUp');
    $api->post('login', 'AuthController@signIn');
    $api->post('forgot-password', 'AuthController@forgotPassword');
    $api->post('resend-otp', 'AuthController@resendOtp');
    $api->post('verify-otp', 'AuthController@verifyOtp');
    $api->post('reset-password', 'AuthController@resetPassword');
    $api->post('social-login', 'SocialLoginController@login');

    //cms
    $api->get('getFaq', 'CmsController@getFaq');
    $api->get('getContactUs', 'CmsController@getContactUs');

    Route::group(['middleware' => ['auth:sanctum']], function ($auth) {
        $auth->post('change-password', 'AuthController@changePassword');
        $auth->post('myprofile', 'AuthController@userProfile');
        $auth->post('profile-update', 'AuthController@profileUpdate');
        $auth->post('logout', 'AuthController@logOut');
    });
});
