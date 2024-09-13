<?php

namespace App\Http\Controllers;

use App\Enums\MaintenancePlanFrequencyEnum;
use App\Enums\MaintenanceScheduleStatusEnum;
use App\Models\MaintenancePlan;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MaintenanceScheduleController extends Controller
{
    public function index(Request $request)
    {
        $maintenanceSchedules = MaintenanceSchedule::with(['maintenancePlan', 'performer'])
            ->latest()->paginate(10);

        return view('maintenance-schedules.index', compact('maintenanceSchedules'));
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

    }

    public function edit(MaintenanceSchedule $maintenanceSchedule)
    {

    }

    public function update(Request $request, MaintenanceSchedule $maintenanceSchedule)
    {

    }

    public function destroy(MaintenanceSchedule $maintenanceSchedule)
    {

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
