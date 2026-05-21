<?php

use Greeate\Greeate\Http\Controllers\Admin\ActivityLogController;
use Greeate\Greeate\Http\Controllers\Admin\AdminController;
use Greeate\Greeate\Http\Controllers\Admin\BannerController;
use Greeate\Greeate\Http\Controllers\Admin\BroadcastController;
use Greeate\Greeate\Http\Controllers\Admin\ContactMessageController;
use Greeate\Greeate\Http\Controllers\Admin\DashboardController;
use Greeate\Greeate\Http\Controllers\Admin\FaqController;
use Greeate\Greeate\Http\Controllers\Admin\LanguageController;
use Greeate\Greeate\Http\Controllers\Admin\NotificationController;
use Greeate\Greeate\Http\Controllers\Admin\PermissionController;
use Greeate\Greeate\Http\Controllers\Admin\ProfileController;
use Greeate\Greeate\Http\Controllers\Admin\RoleController;
use Greeate\Greeate\Http\Controllers\Admin\SiteSettingsController;
use Greeate\Greeate\Http\Controllers\Admin\StaticPageController;
use Illuminate\Support\Facades\Route;

$prefix = config('greeate.admin_prefix', 'admin');

Route::prefix($prefix)
    ->name('greeate.admin.')
    ->middleware('greeate.admin.panel')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('admins', AdminController::class);
        Route::patch('admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])
            ->name('admins.toggle-status')
            ->middleware('greeate.super-admin.protect');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class)->only(['index']);
        Route::resource('banners', BannerController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('languages', LanguageController::class);
        Route::resource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
        Route::resource('static-pages', StaticPageController::class);

        Route::resource('broadcasts', BroadcastController::class);
        Route::post('broadcasts/{broadcast}/send', [BroadcastController::class, 'send'])->name('broadcasts.send');

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::patch('notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');

        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::delete('activity-logs/{id}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');

        Route::get('settings/{group?}', [SiteSettingsController::class, 'index'])->name('settings.index');
        Route::put('settings/{group}', [SiteSettingsController::class, 'update'])->name('settings.update');
    });
