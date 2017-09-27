<?php

namespace App\Amazon;

use GuzzleHttp\Client;
use SimpleXMLElement;
use Goutte\Client as ClientGoutte;
use App\Review;
use Illuminate\Support\Facades\Log;



class AmazonPaApi
{
					// SISTEMARE CON https://www.sitepoint.com/amazon-product-api-exploration-lets-build-a-product-search/
	public static function api_request($keysearch) 
	{

		$client = new Client();  //guzzlehttp extension
	    $aws_access_key_id = env('AWS_ACCESS_KEY_ID');   // Your AWS Access Key ID, as taken from the AWS Your Account page	    
	    $aws_secret_key = env('AWS_SECRET_KEY');  // AWS Secret Key corresponding to the above ID  
	    $endpoint = "webservices.amazon.it";   // The region you are interested in
	    $uri = "/onca/xml";



	    for ($i=1; $i <=2 ; $i++) {  // DA SISTEMARE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!	    

		    $params = array(
		        "Service" => "AWSECommerceService",  //affinare i criteri di ricerca e d irestituzione dati
		        "Operation" => "ItemSearch",
		        "AWSAccessKeyId" => $aws_access_key_id, 
		        "AssociateTag" => "infsol-21",
		        "SearchIndex" => "All",
		        "Keywords" => $keysearch,
		        "ResponseGroup" => "EditorialReview,Images,ItemAttributes,Offers,Reviews",
		        "ItemPage" => $i // pagination
		        //"Sort" => "price"
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
		    $request_url = 'https://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);  // Generate the signed URL
		    
		    // !!! XML RESPONSE FROM GOOGLE : 415 RISULTATI, DIVISI IN 42 PAGINE, 10 PER REQUEST !!!

		    for ($n=1; $n <= 5; $n++) {  // !important --> in caso di errore riprova fino a 5 tentativi a distanzia di 2 secondi !!!

			    try {
			    	Log::info('Amazon Api call - ItemPage: '. $i .' -> tentativo chiamata n. '. $n);
			    	sleep(1);
			      	$response = $client->request('GET', $request_url);  // ['query' => $query]
			      	$status = $response->getStatusCode();
			      	Log::info('Response code: '. $status);
			
			      	
			      	$contents[] = new SimpleXMLElement($response->getBody()->getContents());
			      	break;  // important! interrompe loop dei tentativi in caso di successo 
			      	

			    } catch(Exception $e) {
			      	// echo "something went wrong: <br>";
			      	echo $e->getMessage();
			      	continue;
			      	Log::info('Amazon Api call, errore');
			    }

			    sleep(2);

			} // fine ciclo for


			dump('ciclo '. $i);
			sleep(20);  // IMPORTANT PER EVITARE '503 SERVICE UNAVAILABLE'

		} //fine ciclo for
		// dd('stops');
		
	    
		foreach ($contents as $content) {
				
				foreach($content->Items->Item as $Ite) {
					$itemList[] = $Ite;
					
				}
			
		}

		// dump($itemList);

	    return $itemList;


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