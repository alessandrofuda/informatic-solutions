<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Store;

class StoresTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
    	
    	$amazon_store = Store::where('name', 'amazon')->get();
    	$ebay_store = Store::where('name', 'ebay')->get();

    	if ($amazon_store->isEmpty()) {
    		DB::table('stores')->insert([
	            'name' => 'amazon',
	            'created_at' => Carbon::now(),
	            'updated_at' => Carbon::now()
	        ]);
    	}
        
    	if ($ebay_store->isEmpty()) {
			DB::table('stores')->insert([
	            'name' => 'ebay',
	            'created_at' => Carbon::now(),
	            'updated_at' => Carbon::now()
	        ]);
	    }
    }
}
