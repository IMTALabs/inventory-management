<?php

namespace Database\Factories;

use App\Enums\MaintenancePlanFrequencyEnum;
use App\Enums\MaintenancePlanStatusEnum;
use App\Models\Equipment;
use App\Models\MaintenancePlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MaintenancePlanFactory extends Factory
{
    protected $model = MaintenancePlan::class;

    public function definition(): array
    {
        return [
            'equipment_id' => $this->faker->randomNumber(),
            'plan_name' => $this->faker->sentence(),
            'description' => $this->faker->text(),
            'frequency' => Arr::random(MaintenancePlanFrequencyEnum::cases())->value,
            'status' => MaintenancePlanStatusEnum::OPEN,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
