<?php

namespace Database\Factories;

use App\Models\MaintenanceLog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MaintenanceLogFactory extends Factory
{
    protected $model = MaintenanceLog::class;

    public function definition(): array
    {
        return [
            'equipment_id' => $this->faker->randomNumber(),
            'maintenance_date' => Carbon::now(),
            'maintenance_plan_id' => $this->faker->randomNumber(),
            'maintenance_schedule_id' => $this->faker->randomNumber(),
            'performed_by' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
            'outcome' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
