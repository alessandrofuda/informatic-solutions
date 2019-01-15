<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use UrlSigner;
use App\User;


class ComparatorUserController extends Controller {

    public function deleteMyProfile() {

        $id = Auth::user()->id;
        
        User::destroy($id);  // !! softdelete !!

        return redirect('videocitofoni/comparatore-prezzi')->with('success_message', '<b>Il tuo profilo utente è stato Eliminato Correttamente</b>.<br>Se ti sei cancellato per errore o se vuoi registrarti di nuovo <a href="'. url('register') .'">clicca qui</a>.');

    }



    public function autoDestroy(Request $request, $id) {

        
        $validate = UrlSigner::validate($request->fullUrl());  // bool
        
        if ($validate === false) {

            abort(403);

        } else {

            User::destroy($id);  // !! softdelete !!
            
            $id = (int) $id;
            $code = $id*100*3*67*89;  // encrypt $id 
            

            return redirect('videocitofoni/comparatore-prezzi')->with('success_message', '<b>Il tuo profilo utente è stato Eliminato Correttamente</b>.<br>Se ti sei cancellato per errore e vuoi <b>annullare</b> l\'operazione <a href="'. url('autorestore/'.$code.'') .'">clicca qui</a>.');
        }

    }


    public function autoRestore($code) {

        $id = $code/89/67/3/100; // decrypt $code

        User::withTrashed()
                ->where('id', $id)
                ->restore();

        return redirect('videocitofoni/comparatore-prezzi')->with('success_message', 'Operazione annullata! Sei di nuovo iscritto. Se vuoi accedere al tuo profilo <a href="'.url('login').'">fai il login</a>');

    }


}
