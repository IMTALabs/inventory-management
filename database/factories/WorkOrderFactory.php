<?php

namespace Database\Factories;

use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WorkOrderFactory extends Factory
{
    protected $model = WorkOrder::class;

    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->randomNumber(),
            'equipment_id' => $this->faker->randomNumber(),
            'created_by' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'due_date' => Carbon::now(),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
