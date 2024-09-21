<?php

namespace App\Http\Controllers;

use App\Enums\MaintenanceScheduleStatusEnum;
use App\Models\Equipment;
use App\Models\MaintenanceLog;
use App\Models\MaintenancePlan;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'plan_name' => 'nullable|string|min:3',
            'equipment_name' => 'nullable|string|min:3',
            'performed_by' => 'nullable|string|min:3',
            'date' => 'nullable|date',
            'status' => 'nullable|in:' . implode(',', array_column(MaintenanceScheduleStatusEnum::cases(), 'value')),
            'sort_by' => 'nullable|in:id,maintenance_plan_plan_name,equipment_equipment_name,date',
            'sort_order' => 'nullable|in:asc,desc',
        ]);

        $maintenanceLogQuery = MaintenanceLog::withAggregate('equipment', 'equipment_name')
            ->withAggregate('equipment', 'id')
            ->withAggregate('maintenancePlan', 'plan_name')
            ->withAggregate('performer', 'name')
            ->withAggregate('performer', 'id')
            ->withAggregate('maintenanceSchedule', 'id');

        $maintenanceLogQuery->when($request->query('plan_name'), function ($query) use ($request) {
            $query->whereHas('maintenancePlan', function ($query) use ($request) {
                $query->where('plan_name', 'like', '%' . $request->query('plan_name') . '%');
            });
        });

        $maintenanceLogQuery->when($request->query('equipment_name'), function ($query) use ($request) {
            $query->whereHas('equipment', function ($query) use ($request) {
                $query->where('equipment_name', 'like', '%' . $request->query('equipment_name') . '%');
            });
        });

        $maintenanceLogQuery->when($request->query('performed_by'), function ($query) use ($request) {
            $query->whereHas('performer', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->query('performed_by') . '%');
            });
        });

        $maintenanceLogQuery->when($request->query('date'), function ($query) use ($request) {
            $query->whereDate('maintenance_date', $request->query('date'));
        });

        $maintenanceLogQuery->when($request->query('status'), function ($query) use ($request) {
            $query->where('outcome', $request->query('status'));
        });

        $maintenanceLogQuery->when($request->query('sort_by'), function ($query) use ($request) {
            $query->orderBy($request->query('sort_by'), $request->query('sort_order', 'desc'));
        }, function ($query) {
            $query->orderBy('id', 'desc');
        });

        $maintenanceLogs = $maintenanceLogQuery->paginate(10)->onEachSide(0);

        return view('maintenance-logs.index', compact(
            'maintenanceLogs'
        ));
    }
}
