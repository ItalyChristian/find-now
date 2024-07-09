<?php

use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\SettingProfileUserController;
use Illuminate\Support\Facades\Route;


Route::get('/profile/{slug}', [SettingProfileUserController::class, 'show']);
Route::get('/404', [SettingProfileUserController::class, 'notFound'])->name('profile.notFound');

Route::prefix('panel')->group(function () {

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
})->middleware('auth');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
