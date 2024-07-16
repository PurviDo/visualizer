<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SubCategoryController;

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('admin.auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');

    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('customers', CustomerController::class);

    // Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    // Route::get('/customers/create', [CustomerController::class, 'create']);
    // Route::post('/customers/save', [CustomerController::class, 'save'])->name('customer.store');
    // Route::get('/customers/edit', [CustomerController::class, 'edit']);

    // Template Management
    Route::get('/template_mg', [DashboardController::class, 'index'])->name('dashboard');

    // CMS Management
    Route::get('/cms_mg', [DashboardController::class, 'index'])->name('dashboard');

    //CATEGORY
    Route::resource('category', CategoryController::class);
    Route::resource('sub-category', SubCategoryController::class);

    //PACKAGE 
    Route::resource('packages', PackageController::class);
});
