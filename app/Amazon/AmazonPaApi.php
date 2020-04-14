<?php

namespace App\Amazon;

use Revolution\Amazon\ProductAdvertising\Facades\AmazonProduct;
use App\Exceptions\ItemsNotFoundFromApiException;
use App\Notifications\ScrapingError;
use Illuminate\Support\Facades\Log;
use Goutte\Client as ClientGoutte;
use GuzzleHttp\Client;
use App\Review;
use Exception;
use App\User;
use App;
use App\Console\Commands\ScrapAmazonProductsDescriptions;

class AmazonPaApi {

	/*public static function api_search_request($keysearch) {

		$client = new Client();  //guzzlehttp extension
	    $aws_access_key_id = config('services.amazon_api_keys.aws_access_key_id');   // Your AWS Access Key ID, as taken from the AWS Your Account page	    
	    $aws_secret_key = config('services.amazon_api_keys.aws_secret_key');  // AWS Secret Key corresponding to the above ID  
	    $amazon_affiliat_id = config('services.amazon_api_keys.amazon_affiliat_id');
	    $endpoint = "webservices.amazon.it";   // The region you are interested in
	    $uri = "/onca/xml";


	    for ($i=1; $i <=3 ; $i++) {  	// estraz di (10 x $i) prodotti    

		    $params = array(
		        "Service" => "AWSECommerceService",  //affinare i criteri di ricerca e d irestituzione dati
		        "Operation" => "ItemSearch",
		        "AWSAccessKeyId" => $aws_access_key_id, 
		        "AssociateTag" => $amazon_affiliat_id,
		        "SearchIndex" => "All",
		        "Keywords" => $keysearch,
		        "ResponseGroup" => "EditorialReview,Images,ItemAttributes,Offers,Reviews",
		        "ItemPage" => strval($i) // pagination
		    );

		   
		    if (!isset($params["Timestamp"])) {   // Set current timestamp if not set
		        $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
		    }

		    ksort($params);    // Sort the parameters by key

		    $pairs = array();

		    foreach ($params as $key => $value) {
		        array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
		    }

		    $canonical_query_string = join("&", $pairs);     // Generate the canonical query
		    $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;    // Generate the string to be signed
		    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true)); // Generate the signature required by the PA API
		    $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);  // Generate the signed URL
		    
		    // !!! XML RESPONSE FROM amazon : 10 PER REQUEST !!!

		    for ($n=1; $n <= 5; $n++) {  // !important --> in caso di errore riprova fino a 5 tentativi a distanzia di X secondi !!!

			    //try {
			    	Log::info('Amazon Api call - ItemPage: '. $i .' -> tentativo chiamata n. '. $n);
			    	sleep(1);
			    	// $request_url = 'https://httpbin.org/status/503';  // TESTING --> simula risposta 503
			      	$response = $client->request('GET', $request_url, ['http_errors' => false]);  // IMPORTANT !!
			      	// http_errors --> !!! importante per NON bloccare il flusso http su errore 503-500-etc... !!!
			      	$status = $response->getStatusCode();
			      	Log::info('Response code: '. $status);

			      	if ($status == 200) {
						$contents[] = new SimpleXMLElement($response->getBody()->getContents());  // con NUOVA VERSIONE API diventa Json
			      		break;  // important! interrompe loop dei tentativi in caso di successo 
			      	}
			    //} catch(Exception $e) {
			      	// echo "something went wrong: <br>";
			      	// echo $e->getMessage();
			      	// continue;
			      	//Log::info('Amazon Api call, errore');
			    //}
			    sleep(2);
			} // fine ciclo for
			sleep(10);  // IMPORTANT PER EVITARE '503 SERVICE UNAVAILABLE'
		} //fine ciclo for
		
		foreach ($contents as $content) {
				foreach($content->Items->Item as $Ite) {
					$itemList[] = $Ite;
				}	
		}
	    return $itemList;
	}*/

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

	public function scrap_products_descriptions($detail_product_urls) {
		$timeout = App::environment('local') ? 5 : 30;
		$loop_time = App::environment('local') ? 2 : 61;
		$products_descriptions = [];
		$user_agents = [
			'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36',
			'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.87 Safari/537.36',
			'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:70.0) Gecko/20100101 Firefox/70.0',
			'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.18362',
			'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko',
			'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:75.0) Gecko/20100101 Firefox/75.0'
		];


		// TEST !!!
		// $detail_product_urls = ['https://example.com'];
		// $detail_product_urls = ['http://example.it'];


		
		foreach ($detail_product_urls as $detail_product_url) {
			try {
				// scraping with goutte
				$client = new ClientGoutte();
				$guzzleClient = new Client(['timeout' => $timeout]);
				$client->setClient($guzzleClient);
				$client->setHeader('User-Agent', $user_agents[rand(0,count($user_agents)-1)]);
				$crawler = $client->request('GET', $detail_product_url);
				$html_element = '#productDescription > p'; // '#productDescription > p'; // test 'h1'
				sleep(2);
				$description_nodes = $crawler->filter($html_element)->each(function ($node) {
				    return $node->html();  // text();
				});
				
				if (empty($description_nodes) ) {
					$err_msg = "Error: Html element '".$html_element."' not found during scraping of product Descriptions on Amzn pages. ".$detail_product_url;
					throw new Exception($err_msg, 1);
				} elseif (count($description_nodes) > 1) {
					$err_msg = "Error: Crawler found more than one item matching '".$html_element."' Html element in Amzn Product Page. ".$detail_product_url;
					throw new Exception($err_msg, 2);
				}
			} catch (Exception $e) {
				print($e->getMessage()."\n");
				Log::error($e->getMessage());
				// mail notification
				$admins = User::where('role','admin')->get(['email']);
				$admin_emails = [];
				foreach ($admins as $admin) {
					$admin->notify(new ScrapingError($e->getMessage()));
					$admin_emails[] = $admin->email;
					sleep(3);
				}
				$notif_message = 'Sent notification to: '.rtrim(implode(', ', $admin_emails), ', ');
				print($notif_message.".\n");
				Log::error($notif_message);
				if($e->getCode() == 1 || $e->getCode() == 2) {
					$description_nodes[0] = null;
				} else {
					return false;
				}
			}

			$ASIN_code = substr($detail_product_url, strrpos($detail_product_url, "/")+1);
			$description_node = $description_nodes[0];
			$products_descriptions[$ASIN_code] = $description_node;
			

			sleep($loop_time);
		}


		// test
        // $products_descriptions = [
        //     'B076HFQCQD' => 'descr1',
        //     'B06XKRDN8X' => 'descr2',
        //     'B01F6NC1H0' => 'descr3',
        // ];


		return $products_descriptions;
	}


	public function scrapingreviews($asin_array) {

		//IMPORTANTE: puntando le richieste sulle url "pubbliche" c'è il rischio che il crawler dopo un po' viene bloccato
		// e sottoposto a verifica tramite captcha.
		// se ci sono problemi: usare le url proposte dalla PA API Amazon (utilizzabili solo tramite iframe)

		//per ogni ASIN fa:
		//- una chiamata all'url recensioni
		//- filtra i nodi di interesse
		//- ritorna un array multidimensionale per ogni chiamata


		$reviews_array = array();
		$uri_base = 'https://www.amazon.it/product-reviews/';
		$client = new ClientGoutte();
		$client->setHeader('user-agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");


		// $tag = 'infsol-21';

		foreach ($asin_array as $asin) {
			
			$uri_review = $uri_base . $asin .'/ref=cm_cr_if_all_link?ie=UTF8&linkCode=xm2&showViewpoints=1&sortBy=recent';  // &tag='.$tag;

			//try {
					
				    $crawler = $client->request( 'GET', $uri_review ); //ok --> 10 richieste
				    $votomedio = $crawler->filter('.averageStarRatingNumerical')->each(function ($node) { return $node->text(); });
				    $reviews = $crawler->filter('.review .review-title,   
		    				  			 		 .review .author,
		    				  			 		 .review .review-date,
		    				  			 		 .review .review-text,
		    							 		 .review .review-rating span')
				    					->each(function ($node) {  
    										return $node->text(); 			
								  		});
				    
		 	//} catch(Exception $e) {
			//    	echo "Si è verificato un problema: <br>";
	      	//		echo $e->getMessage();
			//    }
	    
			$splitted_reviews = array_chunk($reviews, 5);  // !! splitta l'array "parent" in sotto-arrays, 5 è il numero dei nodi in filter() !!	
		    array_push($reviews_array, $splitted_reviews);  //ad ogni ciclo del loop aggiunge l'output ($splitted_reviews) all'array $reviews_array
		    array_push($reviews_array , $votomedio);
			//dd($reviews_array); // OK!!
		    
		    $s = rand(1,3);
			sleep($s);

		} // fine ciclo foreach

		
		$reviews_array = array_chunk($reviews_array, 2);
		//dd($reviews_array);
		//important:  !!! --> array_combine()
		$asin_reviews_array = array_combine($asin_array, $reviews_array);
		
		/*  //TESTING
		$asin_reviews_array = [
							   'TEST1B013AZLBB8' => [
														['voto','titolo','autore','data','testo'], 
														['voto1','titolo1','autore1','data1','testo1'], 
														['voto2','titolo2','autore2','data2','testo2'], 
														['voto3','titolo3','autore3','data3','testo3'], 
														['voto4','titolo4','autore4','data4','testo4'],
													],
							   'TEST2B013AZLBB8' => [
							   							['voto0','titolo0','autore0','data0','testo0'], 
							   							['voto5','titolo5','autore5','data5','testo5'], 
							   							['voto6','titolo6','autore6','data6','testo6'], 
							   							['voto7','titolo7','autore7','data7','testo7'], 
							   							['voto8','titolo8','autore8','data8','testo8'],
							   						],
							   'TEST3B013AZLBB8' => [
							   							['voto9','titolo9','autore9','data9','testo9'], 
							   							['voto10','titolo10','autore10','data10','testo10'], 
							   							['voto20','titolo20','autore20','data20','testo20'], 
							   							['voto30','titolo30','autore30','data30','testo30'], 
							   							['voto40','titolo40','autore40','data40','testo40'],
							   						],
							  ];
	  	*/
		
		//dd($asin_reviews_array);

		$asin_reviews_json = json_encode($asin_reviews_array);
		
		return $asin_reviews_json;

	}

	public function insert_reviews_in_db($scrapingreviews_json) {  

        //riceve il json in entrata e inserisce il json in db ('reviews' table)
		$review = new Review;
		$review->json = $scrapingreviews_json;
		$saved = $review->save(); //bool true/false
		

		//elimina vecchi records in db (!!)
		$id_to_delete = $review->id - 3;
		$cleaned = $review->where('id','<=',$id_to_delete)->delete();  //return numero di record cancellati

		if($saved === true && $cleaned !== null) {
			return true;
		}
        
    } 

}