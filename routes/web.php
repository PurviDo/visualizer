<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/login', function () {
    return redirect(route('login'));
});
Route::get('/forgot-password', [AuthController::class, 'forgot_password'])->name('forgot-password');

// Route::middleware('auth:web')->group(function () {
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

// });