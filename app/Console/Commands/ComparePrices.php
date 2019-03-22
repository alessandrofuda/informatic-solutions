<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GoodPriceNotification;
use Illuminate\Support\Facades\Log;

class ComparePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:compareprices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Estrae e Confronta i Prezzi della tabella Prodotti (continuamente aggiornati) con quelli della tabella Watchinglist. Se il primo è minore del secondo invia notifica all\'utente (non più di una al giorno!). (Se ci sono Nuovi prodotti li notifica nella stessa mail.)';

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
    public function handle(){

        $this->line("Comando avviato...");
        $job = new GoodPriceNotification();
        $result = dispatch($job);  // accoda il JOB GoodPriceNotification - cfr. queues in .env

        if($result !== null ){
            $this->info("Comparazione prezzi (JOB) andata a buon fine. Inviate notifiche to users !!");
            Log::info("OK, JOB GoodPriceNotification (fetch:compareprices job). Notifications sent to users");
        } else {
            $this->error("Si è verificato un errore nel JOB  GoodPriceNotification !!");
            Log::info("Si è verificato un errore nel JOB  GoodPriceNotification !!");
        }
    }

    
}
