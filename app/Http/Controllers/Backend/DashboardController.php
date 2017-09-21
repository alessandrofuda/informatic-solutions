<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Watchinglist;
use App\User;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        //$this->slug = 'Migliori prodotti';  // default value for $slug var
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); //User::all();

        $d = explode(' ', $user->created_at);
        $h = explode(':', $d[1]);
        $h = $h[0].':'.$h[1];
        $d = explode('-', $d[0]);
        $d = $d[2].'/'.$d[1].'/'.$d[0]; 

        $date = $d.' - '.$h;


        $watched_items = Watchinglist::where('user_id', Auth::user()->id)
                                     ->where('removed', '!=', 1)
                                     // ->orderBy('removed', 'asc')
                                     ->get();

        $removeds = Watchinglist::where('user_id', Auth::user()->id)
                               ->where('removed', 1)
                               ->get();
        // dd($removed);
        
        return view('backend.home')->with('user', $user)
                                   ->with('date', $date)
                                   ->with('watched_items', $watched_items)
                                   ->with('removeds', $removeds);
    }



    public function changepswd() {

        
        return view('backend.changepswd');  // ?????? verificare (solo l'utente corrente può reimpostare password)
        
    }




    public function postChangepswd(Request $request) {

        $this->validate($request, [
            '_token' => 'required',
            'password' => 'required|min:6|max:60|confirmed',
        ]);

        $credentials = $request->only( '_token', 'password', 'password_confirmation' );

        $user = Auth::user();
        $user->password = bcrypt($credentials['password']);
        
        $user->save();

        return redirect('backend')->with('success_message', 'La tua Password è stata reimpostata correttamente.');

    }



}
