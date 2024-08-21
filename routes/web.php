<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::view('/reset-password/{token}', 'auth.reset-password')->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    // Example Routes
    Route::view('/', 'landing');
    Route::match(['get', 'post'], '/dashboard', function () {
        return view('dashboard');
    });
    Route::view('/pages/slick', 'pages.slick');
    Route::view('/pages/datatables', 'pages.datatables');
    Route::view('/pages/blank', 'pages.blank');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
