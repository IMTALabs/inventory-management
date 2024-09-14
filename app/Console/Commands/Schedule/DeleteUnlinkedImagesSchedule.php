<?php

namespace App\Console\Commands\Schedule;

use App\Console\Commands\DeleteUnlinkedImages;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;

class DeleteUnlinkedImagesSchedule extends Kernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(DeleteUnlinkedImages::class)->dailyAt('23:59');
    }
}
