<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;

// Route::get('/', [AuthController::class, 'index'])->name('login');
// Route::get('/login', function () {
//     return redirect(route('login'));
// });
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::middleware('auth')->group(function () {

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customers/create', [CustomerController::class, 'create']);
    Route::post('/customers/save', [CustomerController::class, 'save'])->name('customer.save');
    Route::get('/customers/edit', [CustomerController::class, 'edit']);

    // Sub Catgories
    Route::get('/sub_catgories', [DashboardController::class, 'index'])->name('dashboard');

    // Packages
    Route::get('/packages', [DashboardController::class, 'index'])->name('dashboard');

    // Template Management
    Route::get('/template_mg', [DashboardController::class, 'index'])->name('dashboard');

    // CMS Management
    Route::get('/cms_mg', [DashboardController::class, 'index'])->name('dashboard');

    //CATEGORY
    Route::resource('category', CategoryController::class);
});
