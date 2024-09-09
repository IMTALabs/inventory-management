<?php

namespace Database\Factories;

use App\Models\MaintenancePlan;
use App\Models\MaintenanceSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MaintenanceScheduleFactory extends Factory
{
    protected $model = MaintenanceSchedule::class;

    public function definition(): array
    {
        return [
            'scheduled_date' => Carbon::now(),
            'status' => $this->faker->word(),
            'remarks' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'maintenance_plan_id' => MaintenancePlan::factory(),
            'performed_by' => User::factory(),
        ];
    }
}
