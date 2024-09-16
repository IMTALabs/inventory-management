<?php

namespace App\Listeners;

use App\Enums\MaintenancePlanStatusEnum;
use App\Enums\MaintenanceScheduleStatusEnum;
use App\Events\MaintenanceScheduleCompleted;
use App\Models\MaintenanceSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckMaintenancePlanStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MaintenanceScheduleCompleted $event): void
    {
        try {
            $maintenanceScheduleId = $event->maintenanceScheduleId;
            $maintenanceSchedule = MaintenanceSchedule::findOrFail($maintenanceScheduleId);
            $maintenancePlan = $maintenanceSchedule->maintenancePlan;

            $completedSchedules = $maintenancePlan
                ->maintenanceSchedules()
                ->whereIn('status', [
                    MaintenanceScheduleStatusEnum::COMPLETED,
                    MaintenanceScheduleStatusEnum::CANCELLED,
                ])
                ->count();

            if ($completedSchedules == $maintenancePlan->maintenanceSchedules()->count()) {
                $maintenancePlan->update([
                    'status' => MaintenancePlanStatusEnum::CLOSED,
                ]);
            }
        } catch (\Throwable $e) {
            dd($e);
            return;
        }
    }
}
