<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceLogController;
use App\Http\Controllers\MaintenancePlanController;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\MetricController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkOrderController;
use App\Models\Equipment;
use App\Models\User;
use App\Models\WorkOrder;
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

    Route::match(['get', 'post'], '/', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('/users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index')->can('viewAny', User::class);
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->can('create', User::class);
        Route::post('/', [UserController::class, 'store'])->name('users.store')->can('create', User::class);
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show')->can('view', 'user');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->can('update', 'user');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update')->can('update', 'user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy')->can('delete', 'user');

        Route::put('/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    });

    Route::prefix('/metrics')->group(function () {
        Route::get('/', [MetricController::class, 'index'])->name('metrics.index');
        Route::post('/', [MetricController::class, 'store'])->name('metrics.store');
    });

    Route::get('/performance-history', [PerformanceController::class, 'history'])->name('performance.history');
    Route::get('/monitor', [MonitorController::class, 'show'])->name('monitor.show');
    Route::get('/monitor/{equipment}/fetch', [MonitorController::class, 'fetchEquipment'])->name('monitor.store');

    Route::prefix('equipment')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('equipments.index')->can('viewAny',
            Equipment::class);
        Route::get('/create', [EquipmentController::class, 'create'])->name('equipments.create')->can('create',
            Equipment::class);
        Route::post('/store', [EquipmentController::class, 'store'])->name('equipments.store')->can('create',
            Equipment::class);
        Route::get('/{equipment}', [EquipmentController::class, 'show'])->name('equipments.show')->can('view',
            'equipment');
        Route::get('/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipments.edit')->can('update',
            'equipment');
        Route::put('/{equipment}', [EquipmentController::class, 'update'])->name('equipments.update')->can('update',
            'equipment');
        Route::delete('/{equipment}',
            [EquipmentController::class, 'destroy'])->name('equipments.destroy')->can('delete', 'equipment');
    });

    Route::prefix('/maintenance-plans')->group(function () {
        Route::get('/', [MaintenancePlanController::class, 'index'])->name('maintenance-plans.index');
        Route::get('/create', [MaintenancePlanController::class, 'create'])->name('maintenance-plans.create');
        Route::post('/', [MaintenancePlanController::class, 'store'])->name('maintenance-plans.store');
        Route::get('/{maintenancePlan}', [MaintenancePlanController::class, 'show'])->name('maintenance-plans.show');
        Route::get('/{maintenancePlan}/edit',
            [MaintenancePlanController::class, 'edit'])->name('maintenance-plans.edit');
        Route::put('/{maintenancePlan}',
            [MaintenancePlanController::class, 'update'])->name('maintenance-plans.update');
        Route::delete('/{maintenancePlan}',
            [MaintenancePlanController::class, 'destroy'])->name('maintenance-plans.destroy');
    });

    Route::prefix('/maintenance-schedules')->group(function () {
        Route::get('/', [MaintenanceScheduleController::class, 'index'])->name('maintenance-schedules.index');
        Route::get('/create', [MaintenanceScheduleController::class, 'create'])->name('maintenance-schedules.create');
        Route::post('/', [MaintenanceScheduleController::class, 'store'])->name('maintenance-schedules.store');
        Route::get('/{maintenanceSchedule}',
            [MaintenanceScheduleController::class, 'show'])->name('maintenance-schedules.show');
        Route::get('/{maintenanceSchedule}/edit',
            [MaintenanceScheduleController::class, 'edit'])->name('maintenance-schedules.edit');
        Route::put('/{maintenanceSchedule}',
            [MaintenanceScheduleController::class, 'update'])->name('maintenance-schedules.update');
        Route::delete('/{maintenanceSchedule}',
            [MaintenanceScheduleController::class, 'destroy'])->name('maintenance-schedules.destroy');
        Route::put('/{maintenanceSchedule}/status',
            [MaintenanceScheduleController::class, 'updateStatus'])->name('maintenance-schedules.update-status');
    });

    Route::prefix('maintenance-logs')->group(function () {
        Route::get('/', [MaintenanceLogController::class, 'index'])->name('maintenance-logs.index');
    });

    Route::prefix('/work-orders')->group(function () {
        Route::get('/', [WorkOrderController::class, 'index'])->name('work-orders.index')
            ->can('viewAny', WorkOrder::class);
        Route::get('/create', [WorkOrderController::class, 'create'])->name('work-orders.create')
            ->can('create', WorkOrder::class);
        Route::post('/', [WorkOrderController::class, 'store'])->name('work-orders.store')
            ->can('create', WorkOrder::class);
        Route::get('/{workOrder}', [WorkOrderController::class, 'show'])->name('work-orders.show')
            ->can('view', 'workOrder');
        Route::get('/{workOrder}/edit', [WorkOrderController::class, 'edit'])->name('work-orders.edit')
            ->can('update', 'workOrder');
        Route::put('/{workOrder}', [WorkOrderController::class, 'update'])->name('work-orders.update')
            ->can('update', 'workOrder');
        Route::delete('/{workOrder}', [WorkOrderController::class, 'destroy'])->name('work-orders.destroy')
            ->can('delete', 'workOrder');
        Route::put('/{workOrder}/update-status',
            [WorkOrderController::class, 'updateStatus'])->name('work-orders.update-status')
            ->can('update', 'workOrder');
    });

    Route::prefix('warranty-requests')->group(function () {
        Route::get('/', [RequestController::class, 'index'])->name('requests.index');
        Route::get('/create', [RequestController::class, 'create'])->name('requests.create');
        Route::post('/', [RequestController::class, 'store'])->name('requests.store');
        Route::get('/{request}', [RequestController::class, 'show'])->name('requests.show');
        Route::get('/{request}/edit', [RequestController::class, 'edit'])->name('requests.edit');
        Route::put('/{request}', [RequestController::class, 'updateStatus'])->name('requests.update-status');
        Route::put('/{request}/update', [RequestController::class, 'update'])->name('requests.update');
        Route::delete('/{request}', [RequestController::class, 'destroy'])->name('requests.destroy');
    });

    Route::post('/image', [EquipmentController::class, 'image'])->name('images.create');
    Route::delete('/image/{id}', [EquipmentController::class, 'deleteImage'])->name('images.delete');
    Route::delete('/image/{id}/all', [EquipmentController::class, 'deleteAllImage'])->name('images.delete_all');

});
