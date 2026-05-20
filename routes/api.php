<?php

use Greeate\Greeate\Http\Controllers\Api\V1\AdminController as ApiAdminController;
use Greeate\Greeate\Http\Controllers\Api\V1\AuthController;
use Greeate\Greeate\Http\Controllers\Api\V1\NotificationController as ApiNotificationController;
use Illuminate\Support\Facades\Route;

$prefix = config('greeate.api_prefix', 'api/v1');

Route::prefix($prefix)->name('greeate.api.')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('auth/me', [AuthController::class, 'me'])->name('auth.me');
        Route::apiResource('admins', ApiAdminController::class);
        Route::get('notifications', [ApiNotificationController::class, 'index'])->name('notifications.index');
        Route::patch('notifications/{id}/read', [ApiNotificationController::class, 'markAsRead'])->name('notifications.read');
    });
});
