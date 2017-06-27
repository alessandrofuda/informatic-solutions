<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use UrlSigner;
use App\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(25);
        //dd($users);

        return view('backend.users-list')->with('users', $users);
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
        $user = User::find($id);

        $d = explode(' ', $user->created_at);
        $d = explode('-', $d[0]);
        $date = $d[2].'/'.$d[1].'/'.$d[0];

        return view('backend.user-edit')->with('user', $user)
                                        ->with('date', $date);
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
        // validate
        $this->validate($request, [
            'name' => 'bail|required',
            'profile' => 'in:subscriber,author,admin',
            ]); 


        $user = User::find($id);

        $user->name = $request->input('name');
        $user->role = $request->input('role');
        $user->save();

        return redirect('backend/users')->with('success_message', 'Il profilo utente di <b>' . $user->name . '</b> è stato modificato correttamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)  // da Admin
    {
        User::destroy($id);  // !! softdelete !!

        return redirect('backend/users')->with('success_message', 'Utente <b>'. $id .'</b> eliminato correttamente (..softDeletes()..)!');
    }



    public function deleteMyProfile() {

        $id = Auth::user()->id;
        
        User::destroy($id);  // !! softdelete !!

        return redirect('videocitofoni/comparatore-prezzi')->with('success_message', '<b>Il tuo profilo utente è stato Eliminato Correttamente</b>.<br>Se ti sei cancellato per errore o se vuoi registrarti di nuovo <a href="'. url('register') .'">clicca qui</a>.');

    }



    public function autoDestroy(Request $request, $id){

        
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
