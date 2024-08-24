<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Equipment;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => config('auth.test_admin_email'),
            'role' => RoleEnum::ADMIN->value,
        ]);

        User::factory()->count(30)->create();

        PerformanceMetric::factory()
            ->count(1000)
            ->for(Equipment::factory()->count(100)->create()->random())
            ->for(Metric::factory()->count(5)->create()->random())
            ->create();
    }
}
