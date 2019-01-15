<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ComparatorController;



class FetchAmazonReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:amazonreviews {keysearch}';  //keysearch --> 'videocitofono' 

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fa chiamata PA API Amazon ed estrae tutte le Recensioni Amazon tramite scraping. Inserisce tutte le recensioni in db in formato json.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        //$this->info("TESTING.. Some text");
        $this->line("Avvio estrazione recensioni Amazon...");
        //$this->comment("Just a comment passing by");
        //$this->question("Why did you do that?");  


        $keysearch = $this->argument('keysearch');
        $this->line('Chiave di ricerca prodotti per recensioni Amazon (keysearch Argument): "'. $keysearch . '"');
        $newistance = new ComparatorController; 
        $result = $newistance->scrapingreview($keysearch); 
        //dd($result);


        if($result === true ){
            $this->info("Scraping e inserimento recensioni Amazon in db eseguiti correttamente !!");
        } else {
            $this->error("Si è verificato un errore in scrapingreview(keysearch) function (o sue sotto-funzioni)  !!");
        }


    }
}
