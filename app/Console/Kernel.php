<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\FetchAmazonProducts::class,  //register custom console artisan commands
        Commands\FetchAmazonReviews::class,
        Commands\ComparePrices::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

        Log::info('Debug: inizio schedule() method in Kernel');
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('fetch:amazonproducts videocitofono')
                 //->everyMinute()
                 //->everyThirtyMinutes()
                 ->hourlyAt(21)  //12
                 ->between('6:00', '23:58')
                 //->daily()
                 ->withoutOverlapping(); //important !!  evita il sovrapporsi dell'esecuzione dei tasks !!
                 
        $schedule->command('fetch:compareprices')
                 ->hourlyAt(24)
                 ->between('6:00', '23:58')
                 ->withoutOverlapping();  //important !!  evita il sovrapporsi dell'esecuzione dei tasks !! 


        //SCRAPING RECENSIONI SOSPESO TEMPORANEAMENTE --> VERIFICARE IL CORRETTO INSERIMENTO DEI PRODOTTI IN DB -- $schedule->command('fetch:amazonreviews videocitofono')
                 //->everyMinute()
                 //->dailyAt('06:35')
                 //->hourly()
        //         ->dailyAt('5:20')
        //         ->withoutOverlapping();



    }





    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
