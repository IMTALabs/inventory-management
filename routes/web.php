<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MetricController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\PerformanceController;
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
        Route::post('/', [UserController::class, 'store'])->name('users.store')->can('create', User::class);
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show')->can('view', 'user');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->can('update', 'user');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update')->can('update', 'user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy')->can('delete', 'user');
    });

    Route::prefix('/metrics')->group(function () {
        Route::get('/', [MetricController::class, 'index'])->name('metrics.index');
        Route::post('/', [MetricController::class, 'store'])->name('metrics.store');
    });

    Route::get('/performance-history', [PerformanceController::class, 'history'])->name('performance.history');
    Route::get('/monitor', [MonitorController::class, 'show'])->name('monitor.show');
    Route::get('/monitor/{equipment}/fetch', [MonitorController::class, 'fetchEquipment'])->name('monitor.store');
});
