<?php

namespace Database\Factories;

use App\Models\Metric;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MetricFactory extends Factory
{
    protected $model = Metric::class;

    public function definition(): array
    {
        $metricNames = [
            'CPU',
            'Memory',
            'Storage',
            'Network',
            'Temperature',
            'Fan Speed',
            'Voltage',
            'Power',
            'Utilization',
            'Latency',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($metricNames),
            'unit' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
