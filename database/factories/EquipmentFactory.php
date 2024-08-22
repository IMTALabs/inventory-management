<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition(): array
    {
        return [
            'equipment_name' => fake()->sentence,
            'equipment_type' => fake()->randomElement(['Server', 'Computer', 'Printer', 'Network Device', 'Other']),
            'model' => fake()->word,
            'serial_number' => fake()->unique()->randomNumber(8),
            'manufacturer' => fake()->company,
            'purchase_date' => fake()->date('Y-m-d'),
            'location' => fake()->address,
            'status' => fake()->randomElement(['Active', 'Inactive', 'Under Repair', 'Pending Disposal']),
            'warranty_period' => fake()->date('Y-m-d', '+1 year'),
            'installation_date' => fake()->date('Y-m-d'),
            'last_service_date' => fake()->date('Y-m-d'),
            'next_service_date' => fake()->date('Y-m-d', '+3 months'),
            'equipment_condition' => fake()->randomElement(['Excellent', 'Good', 'Fair', 'Poor']),
            'equipment_specifications' => fake()->paragraph,
            'usage_duration' => fake()->numberBetween(0, 10000),
            'power_requirements' => fake()->randomNumber(2),
            'network_info' => fake()->ipv4(),
            'software_version' => fake()->randomNumber(3),
            'hardware_version' => fake()->randomNumber(2),
            'purchase_price' => fake()->numberBetween(100, 10000),
            'depreciation_value' => fake()->numberBetween(0, 10000),
            'notes' => fake()->paragraph,
        ];
    }
}
