<?php

namespace App\Amazon;

use Revolution\Amazon\ProductAdvertising\Facades\AmazonProduct;
use App\Exceptions\ItemsNotFoundFromApiException;
use Illuminate\Support\Facades\Log;
use App;


class AmazonPaApi {

	public function api_search_request($keysearch) {
		
		$itemsList = [];
		$category = 'All';
		$seconds = App::environment('local') ? 1 : 4;

		for ($page=1; $page <=3 ; $page++) {  	// estraz di (10 x $page) prodotti   
			try {
				for ($n=1; $n <= 5; $n++) {  // !important --> in caso di errore riprova fino a 5 tentativi a distanzia di X secondi !!!
					Log::info('Amazon Api call - ItemsPage: '. $page .' -> attempt call n. '. $n);
			    	sleep($seconds);
			    	$response = AmazonProduct::search($category, $keysearch , $page); 
			    	if($response) {
			    		$paginateItems[] = $response['SearchResult']['Items'];
			    		break; // important! interrompe loop dei tentativi in caso di successo 
			    	} else {
			    		if ($n == 5) {
			    			throw new ItemsNotFoundFromApiException('No Item found from PA API Call');
			    		}
			    	}
			    	sleep($seconds);
				}
			} catch (ItemsNotFoundFromApiException $e) {
				Log::error('Amazon Api call, error: '. $e->getMessage());
				return null;
			}
			sleep($seconds);
		}
		foreach ($paginateItems as $eachPage) {
			foreach ($eachPage as $item) {
				$itemsList[] = $item;
			}
		}
		return $itemsList;
	} 

}