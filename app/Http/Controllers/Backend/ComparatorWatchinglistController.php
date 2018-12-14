<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Watchinglist;
use App\Product;



class ComparatorWatchinglistController extends Controller {

	public $slug;

	public function __construct() {
        $this->slug = 'videocitofoni';
    }





	public function index() {
		//
	}




    public function add($asin, $product_id) {


    	$limit = 10; // massimo 10 prodotti per utente !!
    	$items = Watchinglist::where('user_id', Auth::user()->id)->get();
    	// dd(count($item));

        $duplicate = Watchinglist::where('user_id', Auth::user()->id)
                                    ->where('product_id', $product_id)
                                    ->get();


        $initialprice = Product::where('asin', $asin)->get()->first()->lowestnewprice;

        if ($initialprice == null || $initialprice == '' || empty($initialprice) ) {
            $initialprice = Product::where('asin', $asin)->get()->first()->price;
        }

        //dd($initialprice);

    	if(count($items) < $limit) {

            if(count($duplicate) > 0) {

                $type_msg = 'error_message';
                $msg = 'Questo oggetto è già presente nella tua lista dei prodotti monitorati. Se è disabilitato lo puoi abilitare direttamente dalla lista sul tuo profilo.<br/><a href="'. url('backend').'">Vai al tuo profilo</a> o <a href="#" data-dismiss="alert" aria-label="close">Prosegui su questa pagina</a>';

            } else {

    	    	$watching = new Watchinglist;

    	    	$watching->user_id = Auth::user()->id;
    	    	$watching->product_id = $product_id;
                $watching->initialprice = $initialprice;

    	    	$watching->save();

    	    	$type_msg = 'success_message';
    	    	$msg = 'L\'oggetto è stato aggiunto alla tua lista dei prodotti monitorati <a href="'. url('backend').'">Vai al tuo profilo</a> o <a href="#" data-dismiss="alert" aria-label="close">Prosegui su questa pagina</a>';
            }

    	} else {

    		$type_msg = 'error_message';
    		$msg = 'Puoi tenere in osservazione massimo <b>'. $limit . '</b> oggetti contemporaneamente.<br/><a href="'.url('backend').'">Vai nel tuo Profilo</a> ed elimina dalla lista quelli più vecchi per aggiungerne di nuovi.';

    	} 


    	return redirect($this->slug . '/comparatore-prezzi')->with($type_msg, $msg);
 

    	// !! mettere l'alert: questo oggetto è già nella tua lista di osservazione
    	
    }



    public function remove(Request $request, $asin, $product_id) {
        
        $item = Watchinglist::where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();
        $item->removed = 1;

        $item->save();

        return redirect('backend')->with('success_message', 'L\'oggetto non è più monitorato, ma è ancora presente nella tua lista.<br/>Per eliminarlo definitivamente cliccare in basso su \'elimina dalla lista\'.');
        
        //modificare il redirect, renderlo dinamico a seconda della pagina di provenienza della richiesta
    }





    public function delete($asin, $product_id) {

        $id = Watchinglist::where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();
        $id->delete();  // true/false        

        return redirect('backend')->with('success_message', 'L\'oggetto è stato eliminato dalla tua lista dei prodotti monitorati');

        //modificare il redirect, renderlo dinamico a seconda della pagina di provenienza della richiesta

    }

    public function restore($asin, $product_id) {

        $item = Watchinglist::where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();
        $item->removed = 0;

        $item->save();

        return redirect('backend')->with('success_message', 'L\'oggetto è stato reinserito nella lista dei prodotti monitorati.');

    }



}
