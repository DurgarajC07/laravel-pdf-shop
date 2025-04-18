<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Auth routes (Laravel's default)
Auth::routes();

// OTP verification routes
Route::middleware('auth')->group(function () {
    Route::get('/otp', [OtpController::class, 'show'])->name('otp.show');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');
    Route::get('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});

// Protected routes (require auth + OTP verification)
Route::middleware(['auth', 'verify.otp'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/products/{product}/purchase', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/products/{product}/download', [ProductController::class, 'download'])->name('products.download');
});

// Purchase confirmation route (public but with token)
Route::get('/purchases/confirm/{token}', [PurchaseController::class, 'confirm'])->name('purchases.confirm');