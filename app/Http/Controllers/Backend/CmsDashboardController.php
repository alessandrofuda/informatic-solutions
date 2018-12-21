<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Post;



class CmsDashboardController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $user = Auth::user();
        $posts = Post::paginate(15);
        $lastArticleId = Post::select('id')->orderBy('id', 'DESC')->first()->id;
        $newArticleId = (int)++$lastArticleId;

        // dd($request->session());

        return view('backend.cmsHome')->with('user', $user)
                                      ->with('posts', $posts)
                                      ->with('newArticleId', $newArticleId);
                                   
    }



    public function newArticleSlugPost(Request $request){

        $rawslug = trim($request->input('slug')) ? : null;
        $rawslug = strtolower($rawslug);
        $slug = preg_replace('/[^a-z0-9 -]+/', '', $rawslug);
        $slug = str_replace(' ', '-', $slug);
        $slug = trim($slug, '-');
        
        Validator::make($request->all(), [
            'slug' => 'required|unique:posts|max:300',
        ])->validate();

        $article = Post::updateOrCreate(['id' => $request->input('id')], ['slug' => $slug]);

        if($article->wasRecentlyCreated){
            $response = 'Nuovo articolo creato con successo';
        } else {
            $response = 'Url aggiornata correttamente (Id articolo: '.$request->input('id').')';
        }
        
        return response()->json(['response' => $response , 'slug' => $slug ]);
    }



    public function newArticlePost(Request $request) {

        //dd($request->all());
        //validat
        Validator::make($request->all(), [
            'article-slug' => 'required|unique:posts|max:300',
            'article-title' => 'required|max:300',
        ])->validate();

        $param = [
            'aticle-slug' => $request->input('article-slug'),
        ];
        $article = Post::updateOrCreate(['id' => $request->input('id')], $param);
        
        // insert in DB
        return response()->json(['response' => '______']);
    }




}
