<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Watchinglist;
use App\Product;
use App\User;



class AdminDashboardController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {   
        $this->middleware(['auth','admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::user(); 
        $date = Product::italian_date($user->created_at);

        $watched_items = Watchinglist::where('user_id', Auth::user()->id)
                                     ->where('removed', '!=', 1)
                                     // ->orderBy('removed', 'asc')
                                     ->get();

        $removeds = Watchinglist::where('user_id', Auth::user()->id)
                               ->where('removed', 1)
                               ->get();
        
        return view('backend.adminHome')->with('user', $user)
                                   ->with('date', $date)
                                   ->with('watched_items', $watched_items)
                                   ->with('removeds', $removeds);
    }


}
