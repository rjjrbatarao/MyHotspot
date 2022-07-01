<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        #this is for multi api auth;
    //$schedule->job(PurgeExpiredApiTokensJob::class)->dailyAt('01:00');
        // $schedule->command('inspire')
        //          ->hourly();
	$schedule->call(function(){
		#store nmcli con sh output to adapter table
		#store nmcli dev output to device table
		#filter nmcli dev based on eth ppp vlan bonding bridge tun and store them to ifaceeth ifacexx tables
	})->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
