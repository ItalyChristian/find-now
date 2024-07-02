<?php

use App\Http\Controllers\Panel\HomeController;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::prefix('panel')->group(function () {

    Route::get('/categories', [HomeController::class, 'index'])->name('categories.index');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
