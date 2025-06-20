<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Log::info('✅ Update Qty Task Staf cron job is running: ' . now());
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            \App\Models\Staf::query()->update([
                'qty_task' => DB::raw("CASE 
                WHEN transportasi = 'motor' AND qty_task < 5 THEN 5
                WHEN transportasi = 'mobil' AND qty_task < 10 THEN 10
                ELSE qty_task
            END")
            ]);
        })->dailyAt('00:01')->appendOutputTo(storage_path('logs/daily-job.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
