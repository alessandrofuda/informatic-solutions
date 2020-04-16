<?php

namespace App\Http\Controllers;

use App\Traits\StoreImageInLocalhostTrait;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Traits\RepairHtmlTrait;
use Illuminate\Http\Request;
use App\Amazon\AmazonPaApi;
use Illuminate\Support\Str;
use App\Product;
use App\Review;
use Exception;
use App\Post;
use Response;
use DB;


class ComparatorController extends Controller {

    use StoreImageInLocalhostTrait;
    use RepairHtmlTrait;

    public $keysearch;

    public function __construct() { 

        //$this->keysearch = 'videocitofono'; 
        $this->page_type = 'comparator';      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug) {  
        // fetch products
        $lastrequest_date = Product::orderBy('updated_at', 'desc')->first()->updated_at;
        $products = Product::where('created_at', '<=', $lastrequest_date)->orderBy('created_at', 'desc');                                                              
        $all_products_number = count($products->get());
        $contents = $products->paginate(15);
        $post_title = '';
        $post = Post::where('slug', $slug)->first();
        
        if($post !== null) {
            $post_title = $post->title; 
        }

        $brands = $this->getBrandsArray();
        $reviews = $this->getReviews();
        
        return view('comparator.index')->with('slug', $slug)
                                       ->with('post_title', $post_title)
                                       ->with('brands', $brands)
                                       ->with('all_products_number', $all_products_number)
                                       ->with('contents', $contents)
                                       ->with('reviews', $reviews)
                                       ->with('page_type', $this->page_type);
                                       //->with('prod_json', $prod_json)
    }

    public function getBrandsArray() {
        $brands_1 = Product::distinct()->orderBy('brand', 'ASC')
                                       ->where('brand', '!=', '') 
                                       ->where('brand', '!=', null)
                                       ->where('brand', 'not like', '-%')
                                       ->get(['brand'])
                                       ->toArray();
        $brands_2 = Product::distinct()->orderBy('brand', 'ASC')
                                       ->where('brand', 'like', '-%')
                                       ->get(['brand'])
                                       ->toArray();
        $brands = array_merge($brands_1, $brands_2);
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
        $all_products_number = count($products->get());

        return view('comparator.index')->with('brands', $brands)
                                       ->with('contents', $contents)
                                       ->with('slug', $slug)
                                       ->with('reviews', $reviews)
                                       ->with('request', $request)
                                       ->with('all_products_number', $all_products_number)
                                       ->with('page_type', $this->page_type); 
    }

    /* 
     *  jquery autocomplete in search form
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
        foreach ($queries as $query) {
            $results[] = [ 'id' => $query->id, 'value' => str_limit( ucfirst(mb_strtolower($query->title)), 80, '...')]; 
        }
        return Response::json($results);
    }

    /*// repair unclosed Html tags
    public function closetags($html) {  // https://gist.github.com/JayWood/348752b568ecd63ae5ce
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</'.$openedtags[$i].'>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }*/

    /**
     *  API call & DB update
     *
    */
    public function FetchAndInsertProductsInDb(string $keysearch, string $storeName = 'not specified') { // storename diventerà array
        $products_from_store = $this->fetchProductsFromStore($keysearch, $storeName);
        
        if ($products_from_store) {
            return $this->insertProductsInDB($products_from_store, $storeName, $keysearch);
        }
    }

    private function fetchProductsFromStore($keysearch, $storeName = 'not specified') {
        if($storeName != 'Amazon') {
            die('Store Name not specified'); // da sistemare quando aggiungerò ebay ed altri stores
        }
        $amazonPaApi = new AmazonPaApi;
        return $amazonPaApi->api_search_request($keysearch);  // array di 30 prodotti
    }

    private function insertProductsInDB($products_from_store, $storeName, $keysearch) {
        $created = 0;
        $updated = 0;
        $deleted = 0;
        $detail_product_urls = [];
        $storedImagesInLocalhost = 0;

        foreach ($products_from_store as $product_from_store) {

            $product_from_store = (object) $product_from_store;
            $product_info = $product_from_store->ItemInfo;

            if (!empty($product_info['Features']['DisplayValues'])) {     // ->ItemAttributes->Feature
                $features_string = '';
                foreach ($product_info['Features']['DisplayValues'] as $feature) {
                    $features_string .= trim($feature, '.') . '. ';
                }
            } else {
                $features_string = '';
            }

            // $editorialreviewcontent_rawhtml = $this->fetchProductDescriptionFromProductDetails($product_from_store->DetailPageURL) ?? null;
            // $editorialreviewcontent = self::repairHtmlAndCloseTags(trim($editorialreviewcontent_rawhtml)) ?? null;

            if ( !empty($product_from_store->Offers['Listings'][0]['Price']['Amount'])) {
                $price = number_format((float) ($product_from_store->Offers['Listings'][0]['Price']['Amount']),2,'.',',');
            } else {
                $price = null;
            }
            
            if (!empty($product_from_store->Offers['Summaries'][0]['LowestPrice'])) {
                $lowestnewprice = number_format((float) ($product_from_store->Offers['Summaries'][0]['LowestPrice']['Amount']),2,'.',',');
            } else {
                $lowestnewprice = null;
            }

            $largeImage = $product_from_store->Images['Primary']['Large'] ?? null;
            $localhostImageUrl = $largeImage['URL'] ? self::storeImageInLocalhost($largeImage['URL'], $storeName.'ProductImages', Str::slug($keysearch)) : null;
            if($localhostImageUrl) {
                $storedImagesInLocalhost++;
            } 
            
            $product_color = $product_info['ProductInfo']['Color'] ?? null;
            
            $product = Product::updateOrCreate(  //evita di creare ASIN duplicati !!
                [
                    'asin' => $product_from_store->ASIN,
                ],
                [
                    'detailpageurl' => $product_from_store->DetailPageURL,
                    'largeimageurl' => $localhostImageUrl, //$product_from_store->LargeImage->URL,
                    'largeimageheight' => $largeImage['Height'] ?? null, 
                    'largeimagewidth' => $largeImage['Width'] ?? null, 
                    'title' => trim($product_info['Title']['DisplayValue']), 
                    'brand' => $product_info['ByLineInfo']['Brand'] ? $product_info['ByLineInfo']['Brand']['DisplayValue'] : null,
                    'feature' => trim($features_string),
                    'color' => $product_color ? trim($product_color['DisplayValue']) : null, 
                    // 'editorialreviewcontent' => $editorialreviewcontent, //non più presente in vers 5 dell'API, prendere l'info con altra chiamata su dettaglio page
                    'price' => $price,
                    'lowestnewprice' => $lowestnewprice,
                ]
            );
            // count how many new records created ... 
            if ($product->wasRecentlyCreated === true) {
                $created++;
            } else {
                $updated++;
            }
            $detail_product_urls[] = $product->detailpageurl; 
        }

        Log::info('Stored '.$storedImagesInLocalhost.' images in localhost');

        //clean old records in db (!!)
        $product_id_to_delete = $product->id - 60;
        $deleted = $product->where('id','<=',$product_id_to_delete)->delete();  // restituisce numero records cancellati
        
        return $product ? ['created'=>$created, 'updated'=>$updated, 'deleted'=>$deleted, 'detail_product_urls'=>$detail_product_urls] : false;  
    }

    public function FetchAndInsertDescriptionsInDb($detail_product_urls, $storeName) {
        try {
            $descriptions_products = $this->fetchDescriptionsFromStore($detail_product_urls, $storeName);
            if (!$descriptions_products) {
                throw new Exception();
            }
        } catch (Exception $e) {
            return false;
        }  
        return $this->insertDescriptionsInDb($descriptions_products);     
    }

    private function fetchDescriptionsFromStore($detail_product_urls, $storeName = 'not specified') {
        if ($storeName != 'Amazon') {
            die('Store Name not specified'); // da sistemare quando aggiungerò ebay ed altri stores
        }

        try {
            $amazonPaApi = new AmazonPaApi;
            $products_descriptions = $amazonPaApi->scrap_products_descriptions($detail_product_urls);  // array di 30 'ASIN' => 'descriptions'
            if (!$products_descriptions) {
                throw new Exception();
            }
        } catch (Exception $e) {

                return false;
        }

        return $products_descriptions;
    }

    private function insertDescriptionsInDb($ASINCodes_descriptions) {
        $updated = 0;
        
        foreach ($ASINCodes_descriptions as $ASIN_code => $description) {
            try {
                $editorialreviewcontent = self::repairHtmlAndCloseTags(trim($description)) ?? null;
                $descr_updated = Product::where('asin',$ASIN_code)->update(['editorialreviewcontent' => $editorialreviewcontent]);
                if (!$descr_updated) {
                    throw new Exception("'ERROR occurred when updating editorialreviewcontent field on DB on ASIN: '".$ASIN_code."'." );
                } else {
                    $updated++;
                }
            } catch (Exception $e) {
                print($e->getMessage()."\n");
                Log::error($e->getMessage());
            }
            
        }

        return $updated > 0 ? ['updated'=>$updated] : null;
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
