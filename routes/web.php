<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenancePlanController;
use App\Http\Controllers\MaintenanceScheduleController;
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

    Route::prefix('equipments')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('equipments.index');
        Route::get('/create', [EquipmentController::class, 'create'])->name('equipments.create');
        Route::post('/store', [EquipmentController::class, 'store'])->name('equipments.store');
        Route::get('/{equipment}', [EquipmentController::class, 'edit'])->name('equipments.edit');
         Route::put('/{equipment}', [EquipmentController::class, 'update'])->name('equipments.update');
        Route::delete('/{equipment}', [EquipmentController::class, 'destroy'])->name('equipments.destroy');
    });

    Route::prefix('/maintenance-plans')->group(function () {
        Route::get('/', [MaintenancePlanController::class, 'index'])->name('maintenance-plans.index');
        Route::get('/create', [MaintenancePlanController::class, 'create'])->name('maintenance-plans.create');
        Route::post('/', [MaintenancePlanController::class, 'store'])->name('maintenance-plans.store');
        Route::get('/{maintenancePlan}', [MaintenancePlanController::class, 'show'])->name('maintenance-plans.show');
        Route::get('/{maintenancePlan}/edit', [MaintenancePlanController::class, 'edit'])->name('maintenance-plans.edit');
        Route::put('/{maintenancePlan}', [MaintenancePlanController::class, 'update'])->name('maintenance-plans.update');
        Route::delete('/{maintenancePlan}', [MaintenancePlanController::class, 'destroy'])->name('maintenance-plans.destroy');
    });

    Route::prefix('/maintenance-schedules')->group(function () {
        Route::get('/', [MaintenanceScheduleController::class, 'index'])->name('maintenance-schedules.index');
        Route::get('/create', [MaintenanceScheduleController::class, 'create'])->name('maintenance-schedules.create');
        Route::post('/', [MaintenanceScheduleController::class, 'store'])->name('maintenance-schedules.store');
        Route::get('/{maintenanceSchedule}', [MaintenanceScheduleController::class, 'show'])->name('maintenance-schedules.show');
        Route::get('/{maintenanceSchedule}/edit', [MaintenanceScheduleController::class, 'edit'])->name('maintenance-schedules.edit');
        Route::put('/{maintenanceSchedule}', [MaintenanceScheduleController::class, 'update'])->name('maintenance-schedules.update');
        Route::delete('/{maintenanceSchedule}', [MaintenanceScheduleController::class, 'destroy'])->name('maintenance-schedules.destroy');
    });
});
Route::post('/image', [EquipmentController::class, 'image'])->name('images.create');
