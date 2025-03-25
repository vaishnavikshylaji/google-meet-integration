<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::resource('categories', CategoriesController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('google-login', [GoogleController::class, 'redirectToGoogle'])->name('google-login');
Route::get('callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('google-meet', [GoogleController::class, 'test'])->name('googleMeet');

