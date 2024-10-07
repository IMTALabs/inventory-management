<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentStatusEnum;
use App\Enums\MaintenancePlanFrequencyEnum;
use App\Enums\MaintenanceScheduleStatusEnum;
use App\Enums\RoleEnum;
use App\Enums\WorkOrderStatusEnum;
use App\Events\MaintenanceScheduleCompleted;
use App\Models\MaintenanceLog;
use App\Models\MaintenancePlan;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceScheduleController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'plan_name' => 'nullable|string',
            'scheduled_date_from' => 'nullable|date',
            'scheduled_date_to' => 'nullable|date|after:scheduled_date_from',
            'performed_by' => 'nullable|exists:users,id',
            'status' => 'nullable|in:' . implode(',', array_column(MaintenanceScheduleStatusEnum::cases(), 'value')),
        ]);

        $planName = $request->input('plan_name');
        $scheduledDateFrom = $request->input('scheduled_date_from');
        $scheduledDateTo = $request->input('scheduled_date_to');
        $performedBy = $request->input('performed_by');
        $status = $request->input('status');

        $maintenanceScheduleQuery = MaintenanceSchedule::with(['maintenancePlan', 'performer']);

        $maintenanceScheduleQuery->when($planName, function ($query, $planName) {
            return $query->whereHas('maintenancePlan', function ($query) use ($planName) {
                return $query->where('plan_name', 'like', "%$planName%");
            });
        });

        $maintenanceScheduleQuery->when($scheduledDateFrom, function ($query, $scheduledDateFrom) {
            return $query->where('scheduled_date', '>=', $scheduledDateFrom);
        });

        $maintenanceScheduleQuery->when($scheduledDateTo, function ($query, $scheduledDateTo) {
            return $query->where('scheduled_date', '<=', $scheduledDateTo);
        });

        $maintenanceScheduleQuery->when($performedBy, function ($query, $performedBy) {
            return $query->where('performed_by', $performedBy);
        });

        $maintenanceScheduleQuery->when($status, function ($query, $status) {
            return $query->where('status', $status);
        });

        $maintenanceScheduleQuery->when(Auth::user()->role === RoleEnum::MAINTAINER, function ($query) {
            return $query->where('performed_by', Auth::id());
        });

        $maintenanceSchedules = $maintenanceScheduleQuery->latest()->paginate(10)->withQueryString();

        $maintainersCompact = User::maintainers()->select(['id', 'name'])->get();

        return view('maintenance-schedules.index', compact(
            'maintenanceSchedules', 'maintainersCompact'
        ));
    }

    public function create()
    {
        $maintenancePlansCompact = MaintenancePlan::select(['id', 'plan_name', 'frequency'])->get();
        $maintainersCompact = User::maintainers()->select(['id', 'name'])->get();

        return view('maintenance-schedules.create', compact([
            'maintenancePlansCompact',
            'maintainersCompact',
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'maintenance_plan_id' => 'required|exists:maintenance_plans,id',
            'performed_by' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'remarks' => 'nullable|string',
            'auto_schedule' => 'nullable',
            'scheduled_to' => 'required_if:auto_schedule,1|date|after:scheduled_date',
        ], [
            'scheduled_to.required_if' => 'The scheduled to field is required when auto schedule is checked.',
            'scheduled_to.after' => 'The scheduled to must be a date after the scheduled date.',
            'maintenance_plan_id.exists' => 'The selected maintenance plan is invalid.',
            'maintenance_plan_id.required' => 'Please select a maintenance plan.',
            'performed_by.exists' => 'The selected performed by is invalid.',
            'performed_by.required' => 'The performed by field is required.',
            'scheduled_date.date' => 'The scheduled date must be a date.',
            'scheduled_date.required' => 'The scheduled date field is required.',
        ]);

        $maintenancePlanId = $request->input('maintenance_plan_id');
        $performedBy = $request->input('performed_by');
        $scheduledDate = Carbon::parse($request->input('scheduled_date'));
        $remarks = $request->input('remarks');
        $autoSchedule = $request->input('auto_schedule');
        $scheduledTo = $request->input('scheduled_to');

        $maintenancePlan = MaintenancePlan::find($maintenancePlanId);
        $scheduledDates = [$scheduledDate->format('Y-m-d')];
        if ($autoSchedule == 1) {
            $frequency = $maintenancePlan->frequency;
            $scheduledDates = $this->autoScheduledDates($scheduledDate, $scheduledTo, $frequency);
        }

        foreach ($scheduledDates as $date) {
            $maintenancePlan->maintenanceSchedules()
                ->create([
                    'performed_by' => $performedBy,
                    'scheduled_date' => $date,
                    'remarks' => $remarks,
                    'status' => MaintenanceScheduleStatusEnum::PENDING->value,
                ]);
        }

        return redirect()->route('maintenance-schedules.index')
            ->with('status', 'Maintenance schedule created successfully.');
    }

    public function show(MaintenanceSchedule $maintenanceSchedule)
    {
        $equipment = $maintenanceSchedule->maintenancePlan->equipment;
        return view('maintenance-schedules.show', compact(
            'maintenanceSchedule',
            'equipment'
        ));
    }

    public function edit(MaintenanceSchedule $maintenanceSchedule)
    {
        $maintenancePlansCompact = MaintenancePlan::select(['id', 'plan_name', 'frequency'])->get();
        $maintainersCompact = User::maintainers()->select(['id', 'name'])->get();

        return view('maintenance-schedules.edit', compact(
            'maintenanceSchedule',
            'maintenancePlansCompact',
            'maintainersCompact'
        ));
    }

    public function update(Request $request, MaintenanceSchedule $maintenanceSchedule)
    {
        $request->validate([
            'performed_by' => 'required|exists:users,id',
            'scheduled_date' => 'required|date',
            'remarks' => 'nullable|string',
        ], [
            'performed_by.exists' => 'The selected performed by is invalid.',
            'performed_by.required' => 'The performed by field is required.',
            'scheduled_date.date' => 'The scheduled date must be a date.',
            'scheduled_date.required' => 'The scheduled date field is required.',
        ]);

        $performedBy = $request->input('performed_by');
        $scheduledDate = Carbon::parse($request->input('scheduled_date'));
        $remarks = $request->input('remarks');

        $maintenanceSchedule->update([
            'performed_by' => $performedBy,
            'scheduled_date' => $scheduledDate,
            'remarks' => $remarks,
        ]);

        return redirect()->route('maintenance-schedules.show', $maintenanceSchedule)
            ->with('status', 'Maintenance schedule updated successfully.');
    }

    public function destroy(MaintenanceSchedule $maintenanceSchedule)
    {
        $maintenanceSchedule->delete();

        return redirect()->route('maintenance-schedules.index')
            ->with('status', 'Maintenance schedule deleted successfully.');
    }

    public function updateStatus(MaintenanceSchedule $maintenanceSchedule, Request $request)
    {
        $maintenanceSchedule->load('maintenancePlan', 'maintenancePlan.equipment');
        $equipment = $maintenanceSchedule->maintenancePlan->equipment;

        $request->validate([
            'status' => 'required|in:' . implode(',', array_column(MaintenanceScheduleStatusEnum::cases(), 'value')),
        ]);

        $status = $request->input('status');

        $maintenanceSchedule->update([
            'status' => $status,
        ]);

        switch ($status) {
            case MaintenanceScheduleStatusEnum::CONFIRMED->value:
                MaintenanceLog::create([
                    'equipment_id' => $maintenanceSchedule->maintenancePlan->equipment_id,
                    'maintenance_date' => now(),
                    'maintenance_plan_id' => $maintenanceSchedule->maintenancePlan->id,
                    'maintenance_schedule_id' => $maintenanceSchedule->id,
                    'performed_by' => Auth::id(),
                    'description' => 'Maintenance schedule confirmed.',
                    'outcome' => MaintenanceScheduleStatusEnum::CONFIRMED->value,
                ]);
                $equipment->update([
                    'next_service_date' => $maintenanceSchedule->scheduled_date,
                    'status' => EquipmentStatusEnum::UNDER_MAINTENANCE,
                ]);
                $equipment->workOrders()->where('status', WorkOrderStatusEnum::ACTIVE)
                    ->update(['status' => WorkOrderStatusEnum::ARCHIVED]);
                break;
            case MaintenanceScheduleStatusEnum::COMPLETED->value:
                MaintenanceLog::create([
                    'equipment_id' => $maintenanceSchedule->maintenancePlan->equipment_id,
                    'maintenance_date' => now(),
                    'maintenance_plan_id' => $maintenanceSchedule->maintenancePlan->id,
                    'maintenance_schedule_id' => $maintenanceSchedule->id,
                    'performed_by' => Auth::id(),
                    'description' => 'Maintenance schedule completed.',
                    'outcome' => MaintenanceScheduleStatusEnum::COMPLETED->value,
                ]);
                $equipment->update([
                    'last_service_date' => $maintenanceSchedule->scheduled_date,
                ]);
                $archivedWorkOrder = $equipment->workOrders()->where('status', WorkOrderStatusEnum::ARCHIVED)->first();
                if ($archivedWorkOrder) {
                    $archivedWorkOrder->update([
                        'status' => WorkOrderStatusEnum::ACTIVE,
                    ]);
                    $equipment->update([
                        'status' => EquipmentStatusEnum::IN_USE,
                    ]);
                } else {
                    $equipment->update([
                        'status' => EquipmentStatusEnum::AVAILABLE,
                    ]);
                }
                break;
            case MaintenanceScheduleStatusEnum::CANCELLED->value:
                MaintenanceLog::create([
                    'equipment_id' => $maintenanceSchedule->maintenancePlan->equipment_id,
                    'maintenance_date' => now(),
                    'maintenance_plan_id' => $maintenanceSchedule->maintenancePlan->id,
                    'maintenance_schedule_id' => $maintenanceSchedule->id,
                    'performed_by' => Auth::id(),
                    'description' => 'Maintenance schedule cancelled.',
                    'outcome' => MaintenanceScheduleStatusEnum::CANCELLED->value,
                ]);
                break;
        }

        MaintenanceScheduleCompleted::dispatch($maintenanceSchedule->id);

        return redirect()->route('maintenance-schedules.show', $maintenanceSchedule)
            ->with('status', 'Maintenance schedule status updated successfully.');
    }

    private function autoScheduledDates(
        Carbon $scheduledDate,
        mixed $scheduledTo,
        MaintenancePlanFrequencyEnum $frequency
    ) {
        $scheduledDates = [];
        $date = $scheduledDate->copy();
        switch ($frequency) {
            case MaintenancePlanFrequencyEnum::DAILY:
                while ($date->lte($scheduledTo)) {
                    $scheduledDates[] = $date->format('Y-m-d');
                    $date->addDay();
                }
                break;
            case MaintenancePlanFrequencyEnum::WEEKLY:
                while ($date->lte($scheduledTo)) {
                    $scheduledDates[] = $date->format('Y-m-d');
                    $date->addWeek();
                }
                break;
            case MaintenancePlanFrequencyEnum::MONTHLY:
                while ($date->lte($scheduledTo)) {
                    $scheduledDates[] = $date->format('Y-m-d');
                    $date->addMonth();
                }
                break;
            case MaintenancePlanFrequencyEnum::QUARTERLY:
                while ($date->lte($scheduledTo)) {
                    $scheduledDates[] = $date->format('Y-m-d');
                    $date->addMonths(3);
                }
                break;
            case MaintenancePlanFrequencyEnum::SEMI_ANNUALLY:
                while ($date->lte($scheduledTo)) {
                    $scheduledDates[] = $date->format('Y-m-d');
                    $date->addMonths(6);
                }
                break;
            case MaintenancePlanFrequencyEnum::ANNUALLY:
                while ($date->lte($scheduledTo)) {
                    $scheduledDates[] = $date->format('Y-m-d');
                    $date->addYear();
                }
                break;
            case MaintenancePlanFrequencyEnum::ONE_TIME:
                $scheduledDates[] = $date->format('Y-m-d');
                break;
        }

        return $scheduledDates;
    }
}
