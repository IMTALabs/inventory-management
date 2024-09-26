<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentStatusEnum;
use App\Enums\MaintenanceScheduleStatusEnum;
use App\Enums\WorkOrderStatusEnum;
use App\Models\Equipment;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use App\Models\WorkOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingWorkOrdersCount = WorkOrder::where('status', WorkOrderStatusEnum::PENDING)->count();
        $incomingMaintenanceSchedulesCount = MaintenanceSchedule::whereIn(
            'status',
            MaintenanceScheduleStatusEnum::incoming()
        )
            ->where('scheduled_date', '>=', now()->format('Y-m-d'))
            ->where('scheduled_date', '<=', now()->addWeek()->format('Y-m-d'))
            ->count();
        $equipmentCount = Equipment::whereIn('status', EquipmentStatusEnum::active())->count();
        $usersCount = User::count();

        $incomingMaintenanceSchedules = MaintenanceSchedule::with('maintenancePlan', 'performer')
            ->whereIn('status', MaintenanceScheduleStatusEnum::incoming())
            ->where('scheduled_date', '>=', now()->format('Y-m-d'))
            ->where('scheduled_date', '<=', now()->addWeek()->format('Y-m-d'))
            ->orderBy('scheduled_date')
            ->limit(5)
            ->get();

        $pendingWorkOrders = WorkOrder::with('equipment', 'user')
            ->where('status', WorkOrderStatusEnum::PENDING)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'pendingWorkOrdersCount',
            'usersCount',
            'incomingMaintenanceSchedulesCount',
            'equipmentCount',
            'incomingMaintenanceSchedules',
            'pendingWorkOrders'
        ));
    }
}
