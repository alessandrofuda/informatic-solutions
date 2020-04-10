<?php

namespace App\Console\Commands;

use App\Http\Controllers\ComparatorController;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Product;
use Exception;

class ScrapAmazonProductsDescriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:scrapamazonproductsdescriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Estrae tramite Scraping (Goutte) le descrizioni dei prodotti in db da pagine prodotto Amzn.';

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
    public function handle() {

        //$this->info("TESTING.. Some text");
        $this->line("Comando avviato...");
        //$this->comment("Just a comment passing by");
        //$this->question("Why did you do that?");  

        $products = Product::orderBy('updated_at', 'desc')->take(30)->get(['detailpageurl']) ?? [];
        $detail_product_urls = [];
        foreach ($products as $product) {
            $detail_product_urls[] = substr($product->detailpageurl, 0, strpos($product->detailpageurl, "?"));
        }
        
        if (!empty($detail_product_urls)) {
            $this->line('Recuperata lista URLs dettagli prodotti');
        } else {
            die($this->error('Errore su lista URLs dettagli prodotti: lista vuota o non esistente.'));
        }
        
        try {
            $this->line('Avvio processo di scraping..');
            $comparator_controller = new ComparatorController; 
            $products_descriptions_in_db = $comparator_controller->FetchAndInsertDescriptionsInDb($detail_product_urls, 'Amazon');
            if (!$products_descriptions_in_db) {
                throw new Exception('$products_descriptions_in_db undefined variable. See logs for details');
            }

        } catch (Exception $e) {
            Log::error('KO. Products description NOT updated in db: '. $e->getMessage());
            $this->error('Si è verificato un errore durante l\'aggiornamento delle descrizioni prodotti in DB: '. $e->getMessage()); 
            return;   
        }
        
        Log::info('OK. '.$products_descriptions_in_db['updated'].' products descriptions updated in db.');
        $this->info('OK. Aggiornate '.$products_descriptions_in_db['updated'].' descrizioni prodotti in database');

    }
}
