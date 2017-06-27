<?php 

namespace App\Traits;

// use Input;
use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;

trait CaptchaTrait {  //con questo Trait il metodo captchaCheck() può essere utilizzato da più classi (cioè da più form, per la validazione)



    public function captchaCheck(Request $request)
    {



        $response = $request->input('g-recaptcha-response');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $secret   = env('RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);
        if ($resp->isSuccess()) {
            return 1;
        } else {
            return 0;
        }

        

    }

}