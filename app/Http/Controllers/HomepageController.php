<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use Illuminate\Http\Request;
use App\Traits\CaptchaTrait;


class HomepageController extends Controller
{


    use CaptchaTrait;




    public function index() {

    	return view('homepage');

    }




    public function index_form(Request $request) {


        $request['captcha'] = $this->captchaCheck($request);

    	$rules = [
    		'nome' => 'required', 
    		'cognome' => 'required', 
    		'email' => 'required | email', 
    		'phone' => 'required', 
    		'come-mi-hai-trovato' => 'required', 
    		'servizio-richiesto' => 'required', 
    		'budget' => 'required', 
            'g-recaptcha-response' => 'required',
            'captcha' => 'required|min:1',
    	];

    	$err_msg = [
    		'nome.required' => 'Inserisci il tuo nome',
    		'cognome.required' => 'Inserisci il tuo cognome',
    		'email.required' => 'Inserisci la tua mail',
    		'email.email' => 'Inserisci una mail valida',
    		'phone.required' => 'Inserisci il tuo numero di telefono',
    		'come-mi-hai-trovato.required' => 'Indica come ci hai trovato, seleziona un\'opzione',
    		'servizio-richiesto.required' => 'Indica il tipo di servizio richiesto. Saleziona un\'opzione',
    		'budget.required' => 'Indica un budget indicativo. Selezione un\'opzione',
            'g-recaptcha-response.required' => 'Metti il flag di fianco a \'Non sono un robot\' per dimostrarmi che sei una persona e non un robot.',
            'captcha.min' => 'Captcha errato, per favore riprova.',
    	];

    	$this->validate($request, $rules, $err_msg);  



    	$request->sito = $request->input('sito-web');
    	$request->come = $request->input('come-mi-hai-trovato');
    	$request->servizio = $request->input('servizio-richiesto');
    	//dd($request);
    	$request->data = date('d-m-Y H:i:s');
		$request->ip = $_SERVER['REMOTE_ADDR'];

		
    	//mail
    	Mail::to(env('ADMIN_EMAIL'))->send(new ContactNotification($request));

    	return redirect('#result')->with('success_message', 'Richiesta inviata correttamente');  


    }

}
