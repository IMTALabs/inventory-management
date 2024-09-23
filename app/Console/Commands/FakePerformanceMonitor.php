<?php

namespace App\Console\Commands;

use App\Models\Equipment;
use App\Models\Metric;
use Illuminate\Console\Command;
use Random\RandomException;

class FakePerformanceMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake-performance-monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake performance monitor data';

    /**
     * Execute the console command.
     *
     * @throws RandomException
     */
    public function handle(): void
    {
        while (true) {
            $metrics = Metric::all();
            $equipments = Equipment::all();
            $equipments->each(function (Equipment $equipment) use ($metrics) {
                $equipment->performanceMetrics()->createMany(
                    $metrics->map(function (Metric $metric) {
                        return [
                            'metric_id' => $metric->id,
                            'metric_value' => random_int(0, 100),
                        ];
                    })->toArray()
                );
                $this->info('Fake performance monitor data created for equipment: ' . $equipment->equipment_name);
            });
            sleep(3);
        }
    }
}
