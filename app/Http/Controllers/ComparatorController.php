<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Amazon\AmazonPaApi;
use App\Product;
use App\Review;
use App\Post;
use Response;
use DB;


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
    public function index($slug) {  

        // fetch products
        $lastrequest_date = Product::orderBy('updated_at', 'desc')->first()->updated_at;

        $contents = Product::where('created_at', '<=', $lastrequest_date)->orderBy('created_at', 'desc')
                                                                         //->take(18)   //ritorna i primi 18 prodotti
                                                                         ->paginate(15)
                                                                         //->get()
                                                                         ;
        $post_title = '';
        $post = Post::where('slug', $slug)->first();
        
        if($post !== null) {
            $post_title = $post->title; 
        }

        // brands array
        $brands = $this->getBrandsArray();
        

        // fetch reviews
        $reviews = $this->getReviews();
        
        return view('comparator.index')->with('slug', $slug)
                                       ->with('post_title', $post_title)
                                       ->with('brands', $brands)
                                       ->with('contents', $contents)
                                       ->with('reviews', $reviews)
                                       //->with('prod_json', $prod_json)
                                       ;
    }



    public function getBrandsArray() {
        $brands = Product::distinct()->orderBy('brand', 'ASC')
                                     ->where('brand', '!=', '') 
                                     ->where('brand', '!=', null)
                                     ->get(['brand']);
        return $brands;
    }




    public function getReviews() {

        $reviews = Review::orderBy('id', 'desc')->first();  
        $reviews = json_decode($reviews->json);

        return $reviews;

    }



    public function filter($slug, Request $request, Product $products) {
        $contents = $products->newQuery();

        if ($request->has('brand')) {
            $contents->whereIn('brand', $request->brand);
        }

        // se array ha 1 valore --> where WhereBetween
        // se array ha più di un valore --> orWhere OR ...

        if ($request->has('price') && is_array($request->price)) {

            $range1 = [0, 100.00];
            $range2 = [100.00, 200.00];
            $range3 = [200.00, 300.00];
            $range4 = [300.00, 10000.00];

            if(count($request->price) === 1) {
                if( in_array('range-1', $request->price) ) {
                    $contents->WhereBetween('lowestnewprice', $range1);    
                } elseif (in_array('range-2', $request->price)) {
                    $contents->WhereBetween('lowestnewprice', $range2); 
                } elseif (in_array('range-3', $request->price)) {
                    $contents->WhereBetween('lowestnewprice', $range3);  
                } elseif (in_array('range-4', $request->price)) {
                    $contents->WhereBetween('lowestnewprice', $range4);
                }
            } elseif( count($request->price) > 1 ){
                
                $ranges_arr = [];
                for ($key = 0; $key < 4; $key++) {  // IMP: 4 loop = range's number
                    if(!empty($request->price[$key])) {
                        if($request->price[$key] == 'range-1') {
                            $ranges_arr[$key] = $range1;
                        } elseif($request->price[$key] == 'range-2') {
                            $ranges_arr[$key] = $range2;
                        } elseif($request->price[$key] == 'range-3') {
                            $ranges_arr[$key] = $range3;
                        } elseif($request->price[$key] == 'range-4') {
                            $ranges_arr[$key] = $range4;
                        }    
                    }else {
                        $ranges_arr[$key] = ['',''];
                    }
                }
                
                $contents->where(function ($query) use ($ranges_arr) {  // $ranges_arr
                    $query->WhereBetween('lowestnewprice', $ranges_arr[0]) 
                          ->orWhereBetween('lowestnewprice', $ranges_arr[1])
                          ->orWhereBetween('lowestnewprice', $ranges_arr[2])
                          ->orWhereBetween('lowestnewprice', $ranges_arr[3]);
                });

            } else {
                return $this->index($slug);
            }
            
        } 

        if ($request->has('q')) {
            // validation
            $this->validate($request, [
                'q' => 'string|nullable',
                ]);

            $term = trim($request->q, '. ');
            $contents->where(function ($query) use ($term){  
                $query->where('asin', 'LIKE', '%'.$term.'%')
                      ->orWhere('title', 'LIKE', '%'.$term.'%')
                      ->orWhere('brand', 'LIKE', '%'.$term.'%')
                      ->orWhere('feature', 'LIKE', '%'.$term.'%')
                      ->orWhere('editorialreviewcontent', 'LIKE', '%'.$term.'%');
            });
        }


        $contents = $contents->get(); // no paginate();
        $brands = $this->getBrandsArray();  // brands array
        $reviews = $this->getReviews();   // fetch reviews

        return view('comparator.index')->with('brands', $brands)
                                       ->with('contents', $contents)
                                       ->with('slug', $slug)
                                       ->with('reviews', $reviews)
                                       ->with('request', $request); 
    }




    /* 
     *  jquery autocomplete in search form
     *
     *
     *
    **/
    public function autocomplete(){

        $term = Input::get('term');
        
        $queries = DB::table('products')
            ->where('asin', 'LIKE', '%'.$term.'%')
            ->orWhere('title', 'LIKE', '%'.$term.'%')
            ->orWhere('brand', 'LIKE', '%'.$term.'%')
            ->orWhere('feature', 'LIKE', '%'.$term.'%')
            ->orWhere('editorialreviewcontent', 'LIKE', '%'.$term.'%')
            ->take(12)
            ->get();
        

        $results = array();
        foreach ($queries as $query)
        {
            $results[] = [ 'id' => $query->id, 'value' => str_limit( ucfirst(mb_strtolower($query->title)), 80, '...')];  //.' - '.$query->asin. ' - '. $query->brand ];
        }

        return Response::json($results);
    }


    /**
     *  API call & DB update
     *
     *
    */
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



    /**
    *   capture reviews text (recensioni)
    *
    */
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
