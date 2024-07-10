<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/login', function () {
    return redirect(route('login'));
});
Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot-password');

// Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });