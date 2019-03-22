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
        // $ok = new ComparatorController; 
        // $result = $ok->FetchAndInsertProductInDb($key);
        $result = ComparatorController::FetchAndInsertProductInDb($key, 'Amazon');
        
        Log::info('OK. Inserito Product in DB (FetchAmazonProducts con key: '. $key.')');

        if($result){
            $this->info("Estrazione e inserimento prodotti Amazon in db eseguiti correttamente !!");
            $this->info("$result[0] nuovi records creati in db e $result[1] records aggiornati.");
        } else {
            $this->error("Si è verificato un errore in FetchAndInsertProductInDb(key) function  !!");
        }
    }
}
