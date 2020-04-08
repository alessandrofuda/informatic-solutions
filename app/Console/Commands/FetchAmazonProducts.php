<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ComparatorController;



class FetchAmazonProducts extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:amazonproducts {keysearch}';  // aggiungere eventualmente l'opzione {--istest=}   --> true/false

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Estrae prodotti tramite PA API AMAZON e li inserisce in db --> products table.';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() { //metodo eseguito quando viene lanciato il comando da CLI
        
        //$this->info("TESTING.. Some text");
        $this->line("Comando avviato...");
        //$this->comment("Just a comment passing by");
        //$this->question("Why did you do that?");  

        $key = $this->argument('keysearch');

        $this->line('Chiave di ricerca inserita (keysearch): '. $key);
        $comparator_controller = new ComparatorController; 
        $products_in_db = $comparator_controller->FetchAndInsertProductsInDb($key, 'Amazon');

        if($products_in_db){
            Log::info('OK. '.$products_in_db['created'].' new Products inserted in DB (FetchAmazonProducts con key: '. $key.')');
            Log::info('OK. '.$products_in_db['updated'].' Products updated in DB');
            Log::info('OK. '.$products_in_db['deleted'].' old Products deleted from DB');
            $this->info("Estrazione e inserimento prodotti Amazon in db eseguiti correttamente !!");
            $this->info($products_in_db['created']." nuovi records creati in db, ".$products_in_db['updated']." records aggiornati e ".$products_in_db['deleted']." vecchi record cancellati.");

            // add descriptions in db - 2nd API call
            $products_descriptions_in_db = $comparator_controller->FetchAndInsertDescriptionsInDb($products_in_db['detail_product_urls'], 'Amazon');
            if ($products_descriptions_in_db) {
                Log::info('OK. Products descriptions updated in db.');
                $this->info('Aggiornate descrizioni prodotti in database');
            } else {
                Log::error('KO. Products description NOT updated in db');
                $this->error('Si è verificato un errore in durante l\'aggiornamento delle descrizioni prodotti in DB');
            }

        } else {
            Log::error('Nessun Product estratto nè inserito in DB.');
            $this->error("Si è verificato un errore in FetchAndInsertProductInDb(key) function  !!");
        }
    }
}
