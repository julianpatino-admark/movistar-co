<?php

use App\Http\Controllers\MonitorRecoveryController;
use App\Http\Middleware\MonitorHeaders;
use App\Http\Middleware\ThrottleMonitor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;

Route::prefix('monitor')->middleware(['web', MonitorHeaders::class])->group(function () {
    Route::middleware('guest:web')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->middleware(ThrottleMonitor::class.':monitor-login')->name('login.store');
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [MonitorRecoveryController::class, 'store'])->middleware(ThrottleMonitor::class.':monitor-recovery')->name('password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->middleware(ThrottleMonitor::class.':monitor-password')->name('password.update');
    });
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:web')->name('logout');
    Route::middleware(['auth:web', 'auth.session', 'can:viewGoContactMonitor'])->group(function () {
        Route::view('account', 'monitor.account')->name('monitor.account');
        Route::put('password', [PasswordController::class, 'update'])->middleware(ThrottleMonitor::class.':monitor-password')->name('user-password.update');
    });
});
