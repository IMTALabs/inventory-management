<?php

namespace Database\Factories;

use App\Models\PerformanceMetric;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PerformanceMetricFactory extends Factory
{
    protected $model = PerformanceMetric::class;

    public function definition(): array
    {
        return [
            'equipment_id' => $this->faker->randomNumber(),
            'metric_id' => $this->faker->randomNumber(),
            'metric_value' => $this->faker->numberBetween(0, 100),
            'created_at' => $this->faker->unique()->dateTimeBetween('-1 day'),
            'updated_at' => Carbon::now(),
        ];
    }
}
