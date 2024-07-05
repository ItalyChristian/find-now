<?php

use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\HomeController;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::prefix('panel')->group(function () {

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
})->middleware('auth');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
