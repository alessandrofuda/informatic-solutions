<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
// use Illuminate\Support\Facades\Log;


class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\FetchAmazonProducts::class,  //register custom console artisan commands
        Commands\FetchAmazonReviews::class,
        Commands\ComparePrices::class,
        Commands\ScrapAmazonProductsDescriptions::class,
        Commands\DeleteOldNotVerifiedUsers::class,
        Commands\DeleteSpamComments::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

        // $schedule->command('inspire')
        //          ->everyMinute();


        $schedule->command('fetch:amazonproducts videocitofono')->hourlyAt(22)->between('6:00', '23:58')->withoutOverlapping(); 
        $schedule->command('fetch:compareprices')->hourlyAt(25)->between('6:00', '23:58')->withoutOverlapping(); 
        $schedule->command('fetch:scrapamazonproductsdescriptions')->dailyAt('05:30')->withoutOverlapping();
        $schedule->command('custom:delete-unverified-users')->monthlyOn(07, '12:57')->withoutOverlapping();
        $schedule->command('custom:delete-spam-comments')->monthlyOn(26, '23:00')->withoutOverlapping();

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
