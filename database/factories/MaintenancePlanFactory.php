<?php

namespace Database\Factories;

use App\Enums\MaintenancePlanFrequencyEnum;
use App\Models\Equipment;
use App\Models\MaintenancePlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class MaintenancePlanFactory extends Factory
{
    protected $model = MaintenancePlan::class;

    public function definition(): array
    {
        return [
            'equipment_id' => $this->faker->randomNumber(),
            'plan_name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'frequency' => Arr::random(MaintenancePlanFrequencyEnum::cases())->value,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
