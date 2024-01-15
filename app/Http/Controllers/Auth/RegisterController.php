<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

// aggiunti per verifica e-mail nel processo di registrazione
use DB;
use Mail;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use App\Mail\NewSubscribedNotification;





class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }


    public function showRegistrationForm() {

        return view('auth.register', ['page_type' => 'register-page', 'slug' => 'register']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'email_token' => str_random(10),
        ]);
    }





    /**
    *  ... per inserimento verifica mail nel processo di registrazione nuovi utenti 1 ...
    *
    *  Over-ridden the register method from the "RegistersUsers" trait
    *  Remember to take care while upgrading laravel
    */

    public function register(Request $request)
    {
        abort(403, "Unauthorized");

        // Laravel validation
        $this->validator($request->all())->validate();

        // deprecated 03/04/2020
        // $validator = $this->validator($request->all());
        // if ($validator->fails())
        // {
        //     $this->throwValidationException($request, $validator);
        // }

        // Using database transactions is useful here because stuff happening is actually a transaction
        // I don't know what I said in the last line! Weird!
        DB::beginTransaction();

        try
        {
            $user = $this->create($request->all());
            //dd($user);  //OK

            // After creating the user send an email with the random token generated in the create method above
            $email = new EmailVerification(new User(['email_token' => $user->email_token, 'name' => $user->name]));

            Mail::to($user->email)->send($email);

            DB::commit(); //inserisce in db

            return back()->with('success_message', 'E\' stata Inviata un\'e-mail all\'indirizzo indicato.<br>Aprila e clicca su \'Conferma\' per convalidare la tua registrazione.');
        }
        catch(Exception $e)
        {
            DB::rollback();
            return back()->with('error_message', 'Si è verificato un errore. Riprova in un secondo momento.');
        }

    }



    /**
    *  ... per inserimento verifica mail nel processo di registrazione nuovi utenti 2 ...
    *
    */
    // Get the user who has the same token and change his/her status to verified i.e. 1
    public function verify($token) {
        // The verified method has been added to the user model and chained here
        // for better readability
        $user = User::where('email_token',$token)->firstOrFail();
        $user->setVerified();


        $admins = User::where('role','admin')->get();  //collection
        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue(new NewSubscribedNotification($user));
        }


        return redirect('login')->with('slug', 'migliori prodotti')
                                ->with('success_message', 'E-mail correttamente verificata.<br>Fai il Login e procedi.');
    }



}
