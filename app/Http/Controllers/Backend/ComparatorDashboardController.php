<?php

namespace App\Http\Controllers\Backend;

use App\Notifications\EmailConfirmationRequest;
use App\Http\Requests\ChangeMyProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Watchinglist;
use Notification;
use App\Product;
use App\User;



class ComparatorDashboardController extends Controller {

    public function __construct() {   
        //$this->slug = 'Migliori prodotti';  // default value for $slug var
        $this->middleware('auth')->except('emailConfirmation');
    }

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
        
        return view('backend.comparatorHome')->with('user', $user)
                                   ->with('date', $date)
                                   ->with('watched_items', $watched_items)
                                   ->with('removeds', $removeds);
    }


    public function changepswd() {

        return view('backend.comparatorChangepswd');  // ?????? verificare (solo l'utente corrente può reimpostare password)
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

        return back()->with('success_message', 'La tua Password è stata reimpostata correttamente.');
    }


    public function changeMyProfile() {

        return view('backend.comparatorChangeMyProfile', ['user' => Auth::user()]); 
    }

    public function postChangeMyProfile(ChangeMyProfileRequest $request) {

        $email_token = str_random(10);
        $user = new User;
        $user->email = $request->input('email');
        $params = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'token' => $email_token
        ];
        
        try {
            Auth::user()->update(['email_token' => $email_token]);
            Notification::send($user, new EmailConfirmationRequest($params));
        } catch (Exception $e) {
            return back()->with('error_message', 'Si è verificato un errore: '.$e->getMessage());
        }

        $path = Auth::user()->getRoutePrefixByRole();
        return redirect()->route($path.'home')->with('success_message', 'Ti è stata inviata una mail al nuovo indirizzo. Clicca sulla mail per confermare.');
    }

    public function emailConfirmation($token) {

        if (Auth::check()) {
            $route_prefix = Auth::user()->getRoutePrefixByRole();
            $route = $route_prefix.'home';
        } else {
            $route = 'login';
        }

        try {
            try {
                $params = decrypt($token);
            } catch (DecryptException $e) {
                
            }
            
            $user = User::where('email_token', $params['token'])->first();
            if ($user) {
                $user->name = $params['name'];
                $user->email = $params['email'];
                $user->setVerified();
            }   

        } catch (Exception $e) {
            
            return redirect()->route('login')->with('error_message', 'Mail non verificata: '.$e->getMessage());
        }   

        return redirect()->route($route)->with('success_message', 'Profilo modificato con successo');
    }

}
