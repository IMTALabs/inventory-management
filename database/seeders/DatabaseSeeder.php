<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Equipment;
use App\Models\MaintenancePlan;
use App\Models\Metric;
use App\Models\PerformanceMetric;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Invent Admin',
            'email' => config('auth.test_admin_email'),
            'role' => RoleEnum::ADMIN->value,
        ]);

        User::factory()->count(30)->create([
            'role' => RoleEnum::STAFF->value,
        ]);

        User::factory()->count(5)->create([
            'role' => RoleEnum::MAINTAINER->value,
        ]);

        User::factory()->count(5)->create([
            'role' => RoleEnum::MANAGER->value,
        ]);

        $equipments = Equipment::factory()->count(100)->create();

        $metrics = Metric::factory()->count(10)->create();

        PerformanceMetric::factory()
            ->count(1000)
            ->for($equipments->random())
            ->for($metrics->random())
            ->create();

        MaintenancePlan::factory()
            ->count(20)
            ->for($equipments->random())
            ->create();
    }
}
