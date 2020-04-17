<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use UrlSigner;
use App\User;


class AdminUserController extends Controller {


    public function __construct() {
        $this->middleware(['auth','admin']);   
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $users = User::where('verified', true)->paginate(25);

        return view('backend.adminUsersList')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $user = User::find($id);
        $d = explode(' ', $user->created_at);
        $d = explode('-', $d[0]);
        $date = $d[2].'/'.$d[1].'/'.$d[0];

        return view('backend.adminUserEdit')->with('user', $user)
                                            ->with('date', $date);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {   
        // validate
        $this->validate($request, [
            'name' => 'bail|required',
            'profile' => 'in:subscriber,author,admin',
            ]); 

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->role = $request->input('role');
        $user->save();

        return redirect()->back()->with('success_message', 'Il profilo utente di <b>' . $user->name . '</b> è stato modificato correttamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        User::destroy($id);  // !! softdelete !!
        return redirect()->back()->with('success_message', 'Utente <b>'. $id .'</b> eliminato correttamente (..softDeletes()..)!');
    }


}
