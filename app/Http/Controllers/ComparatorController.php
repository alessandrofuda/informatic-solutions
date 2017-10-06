<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Amazon\AmazonPaApi;
use App\Review;
use App\Product;


class ComparatorController extends Controller
{

    public $keysearch;

    public function __construct()  //valore di default valido per tutti i metodi sottostanti
    {
        //$this->keysearch = 'videocitofono';
        //dd($this->keysearch);
        
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        // fetch products
        $lastrequest_date = Product::orderBy('updated_at', 'desc')->first()->updated_at;
        $contents = Product::where('created_at', '<=', $lastrequest_date)->orderBy('created_at', 'desc')->take(18)->get();  //ritorna i primi 18 prodotti
        //foreach ($contents as $value) {
        //    dump($value->asin);
        //}
        //dd('ok');
        

        // fetch reviews
        $reviews = Review::orderBy('id', 'desc')->first();  
        $reviews = json_decode($reviews->json);
        // dd($reviews);
        // $prod_json = json_encode($contents);

        // dd($prod_json);

        return view('comparator.index')->with('slug', $slug)
                                       ->with('contents', $contents)
                                       ->with('reviews', $reviews);
                                       // ->with('prod_json', $prod_json);
                                       
    }




    public static function FetchAndInsertProductInDb($keysearch) {  //attivata tramite custom console command

        // $request = new AmazonPaApi;
        // $contents = $request->api_request($keysearch);  //array di 20 prodotti
        $contents = AmazonPaApi::api_request($keysearch);   //array di 20 prodotti
        // dd($contents);


        $created = 0;
        $updated = 0;
        
        //inserisce i prodotti in db
        foreach ($contents as $content) {

            //dd($content);
            if (!empty($content->ItemAttributes->Feature)){
                $string = '';
                foreach ($content->ItemAttributes->Feature as $feature) {
                    $string .= trim($feature, '.') . '. ';
                }
            } else {
                $string = '';
            }

            if (!empty($content->EditorialReviews->EditorialReview->Content)){
                $editorialreviewcontent = trim($content->EditorialReviews->EditorialReview->Content);
            } else {
                $editorialreviewcontent = null;
            }

            if ( !empty($content->Offers->Offer->OfferListing->Price->Amount)) {
                $price = number_format((float) ($content->Offers->Offer->OfferListing->Price->Amount / 100),2,'.',',');
            } else {
                $price = null;
            }
            
            if (!empty($content->OfferSummary->LowestNewPrice->Amount)) {
                $lowestnewprice = number_format((float) ($content->OfferSummary->LowestNewPrice->Amount / 100),2,'.',',');
            } else {
                $lowestnewprice = null;
            }



            $product = Product::updateOrCreate(  //evita di creare ASIN duplicati !!

                [
                    'asin' => $content->ASIN,
                ],
                [
                    'detailpageurl' => $content->DetailPageURL,
                    'largeimageurl' => $content->LargeImage->URL,
                    'largeimageheight' => $content->LargeImage->Height,
                    'largeimagewidth' => $content->LargeImage->Width,
                    'title' => trim($content->ItemAttributes->Title),
                    'brand' => $content->ItemAttributes->Brand,
                    'feature' => trim($string),
                    'color' => trim($content->ItemAttributes->Color),
                    'editorialreviewcontent' => $editorialreviewcontent,
                    'price' => $price,
                    'lowestnewprice' => $lowestnewprice,                    
                ]

            );

            // count how many new records created ... 
            // dd($product->wasRecentlyCreated); // bool
            if ($product->wasRecentlyCreated === true) {
                $created++;
            } else {
                $updated++;
            }
        }



        //elimina vecchi records in db (!!)
        $id_to_delete = $product->id - 60;
        //$today = ;
        $cleaned = $product->where('id','<=',$id_to_delete)->delete();  // restituisce numero records cancellati
        
        
        if($product) {
            
            return array($created, $updated); 

        } else {

            return false;

        }

        
    }




    public function scrapingreview($keysearch)  //attivata tramite custom console command
    {

        $asin_array = Product::pluck('asin')->all();    // pluck: fetch only one column, not all()
        

        $scraprequest = new AmazonPaApi;
        $scrapingreviews_json = $scraprequest->scrapingreviews($asin_array); //crea il json di tutte le reviews da salvare in db      
        $insert_rw_in_db = $scraprequest->insert_reviews_in_db($scrapingreviews_json); // insert in db

        if( !empty($scrapingreviews_json) && $insert_rw_in_db === true ) {
            return true;
        }

    }



    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
