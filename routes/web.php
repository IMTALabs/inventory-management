<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;
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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::match(['get', 'post'], '/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index')->can('viewAny', User::class);
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->can('create', User::class);
        Route::post('/store', [UserController::class, 'store'])->name('users.store')->can('create', User::class);
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show')->can('view', 'user');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->can('update', 'user');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update')->can('update', 'user');
    });
});
