<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentStatusEnum;
use App\Enums\MaintenanceScheduleStatusEnum;
use App\Enums\WorkOrderStatusEnum;
use App\Models\Equipment;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingWorkOrdersCount = WorkOrder::where('status', WorkOrderStatusEnum::PENDING)->count();
        $usersCount = User::count();
        $incomingMaintenanceSchedulesCount = MaintenanceSchedule::whereIn('status',
            MaintenanceScheduleStatusEnum::incoming())->count();
        $equipmentCount = Equipment::whereIn('status', EquipmentStatusEnum::active())->count();

        return view('dashboard', compact(
            'pendingWorkOrdersCount',
            'usersCount',
            'incomingMaintenanceSchedulesCount',
            'equipmentCount'
        ));
    }
}
