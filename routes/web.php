<?php

use Greeate\Greeate\Http\Controllers\Frontend\ComingSoonController;
use Greeate\Greeate\Http\Controllers\Frontend\ContactController;
use Greeate\Greeate\Http\Controllers\Frontend\HomeController;
use Greeate\Greeate\Http\Controllers\Frontend\MaintenanceController;
use Greeate\Greeate\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'greeate.locale', 'greeate.maintenance', 'greeate.inertia'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('greeate.home');
    Route::get('/coming-soon', [ComingSoonController::class, 'index'])->name('greeate.coming-soon');
    Route::get('/contact', [ContactController::class, 'index'])->name('greeate.contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('greeate.contact.store');
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('greeate.maintenance');
    Route::get('/page/{slug}', [PageController::class, 'show'])->name('greeate.page');
    Route::post('/language/{locale}', function (string $locale) {
        session(['locale' => $locale]);
        cookie()->queue('locale', $locale, 60 * 24 * 365);

        return back();
    })->name('greeate.language.switch');
});
