<?php

use Greeate\Greeate\Http\Controllers\Auth\ForgotPasswordController;
use Greeate\Greeate\Http\Controllers\Auth\LoginController;
use Greeate\Greeate\Http\Controllers\Auth\RegisterController;
use Greeate\Greeate\Http\Controllers\Auth\ResetPasswordController;
use Greeate\Greeate\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('greeate.auth')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('greeate.login');
    Route::post('login', [LoginController::class, 'store'])->name('greeate.login.store');
    Route::post('logout', [LoginController::class, 'destroy'])->name('greeate.logout');
    Route::get('register', [RegisterController::class, 'index'])->name('greeate.register');
    Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('greeate.password.request');
    Route::get('reset-password', [ResetPasswordController::class, 'index'])->name('greeate.password.reset');
    Route::get('verify-email', [VerificationController::class, 'index'])->name('greeate.verification.notice');
});
