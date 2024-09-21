<?php

namespace Database\Factories;

use App\Models\WorkOrderHistory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WorkOrderHistoryFactory extends Factory
{
    protected $model = WorkOrderHistory::class;

    public function definition(): array
    {
        return [
            'work_order_id' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
