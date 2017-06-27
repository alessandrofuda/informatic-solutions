<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;   //aggiunto per customizzare il redirect after logout



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/backend';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    
    //Override of the credentials method from the "AuthenticateUsers"
    //permette il login solo agli utenti verificati !!
    public function credentials(Request $request)
    {
        return [
            'email' => $request->email,
            'password' => $request->password,
            'verified' => 1,
        ];
    }



    //AGGIUNTO PER SOVRASCRIVERE DA AuthenticatesUsers il redirect dopo il logout..
    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {   

        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/videocitofoni/comparatore-prezzi'); // più avanti sistemare con..  '/{slug}/comparatore-prezzi'
    }





}
