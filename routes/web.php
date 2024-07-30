<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Cms\ContactUsController;
use App\Http\Controllers\Admin\Cms\FaqCategoryController;
use App\Http\Controllers\Admin\Cms\FaqController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\CMSController;
use App\Models\Cms\ContactUs;

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('admin.auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');

    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password-post', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');

    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('show-profile', [AuthController::class, 'showProfile'])->name('show.profile');
    Route::get('show-changePassword', [AuthController::class, 'showChangePassword'])->name('show.changePassword');
    Route::post('update-profile', [AuthController::class, 'updateProfile'])->name('update.profile');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('change.password');
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('customers', UserController::class);

    // Template Management
    Route::get('/template_mg', [DashboardController::class, 'index'])->name('dashboard');

    // CMS Management
    Route::get('/about-us', [CMSController::class, 'aboutUs'])->name('aboutus');
    // Route::get('/contact-us', [CMSController::class, 'contactUs'])->name('contactus');
    Route::get('/terms-conditions', [CMSController::class, 'termsConditions'])->name('termsconditions');
    Route::get('/privacy-policy', [CMSController::class, 'privacyPolicy'])->name('privacypolicy');
    Route::get('/faq-section', [CMSController::class, 'faqSection'])->name('faqsection');
    Route::get('/faqs', [CMSController::class, 'faqsDetails'])->name('faqs');

    //CATEGORY
    Route::resource('category', CategoryController::class);
    Route::resource('sub-category', SubCategoryController::class);

    //CMS
    Route::resource('faq-category', FaqCategoryController::class);
    Route::resource('faq', FaqController::class);
    Route::resource('contact-us', ContactUsController::class);

    //PACKAGE 
    Route::resource('packages', PackageController::class);

    Route::get('/', function () {
        return redirect()->route('category.index');
    });
});
