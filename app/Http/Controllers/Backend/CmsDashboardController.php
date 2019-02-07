<?php

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
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


    public function sanitizeSlug($rawSlug){
        
        $rawslug = strtolower($rawSlug);
        $slug = preg_replace('/[^a-z0-9 -]+/', '', $rawslug);
        $slug = str_replace(' ', '-', $slug);
        $sanitizedSlug = trim($slug, '-');
        
        return $sanitizedSlug;
    }



    public function slugAlreadyInDb($slug){ 
        // return null or object
        return Post::where('slug', $slug)->first(); 
    }



    public function saveArticleSlug(Request $request) {

        Validator::make($request->all(), [
            'slug' => 'required|max:300', 
        ])->validate();

        $rawslug = trim($request->input('slug')) ? : null;
        $slug = $rawslug ? $this->sanitizeSlug($rawslug) : null;


        if($this->slugAlreadyInDb($slug)) {

            $response = 'Slug già presente in Database';
        
        } else {

            $article = Post::updateOrCreate(['id' => $request->input('id')], ['slug' => $slug]);

            if($article->wasRecentlyCreated){
                $response = 'Nuovo articolo creato con successo';
            } else {
                $response = 'Url aggiornata correttamente (Id articolo: '.$request->input('id').')';
            }
        }
        
        return response()->json(['response' => $response , 'slug' => $slug ]);
    }


    public function saveArticle(Request $request) {

        $validator = Validator::make($request->all(), [
            'slug' => 'required|max:300',
            'title' => 'required|max:300',
        ])->validate();



dd('ok');

        
        $rawslug = trim($request->input('slug')) ? : null;
        $slug = $rawslug ? $this->sanitizeSlug($rawslug) : null;
         


        $params = [
            'author_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'body' => $request->input('body'),
            'slug' => $slug, 
            // 'images' => $request->input(''),
            'active' => $request->input('published'),
        ];

        $article = Post::updateOrCreate(['id' => $request->input('id')], $params);
        //se il post è Creato nuovo (not updated) bisogna controllare che lo slug SANITIZZATO non esista GIÀ
        if($article->wasRecentlyCreated && $this->slugAlreadyInDb($article->slug)){
            $article->fill(['slug' => $article->slug.'-duplicatedSlug-'.rand(0,900)]);  // update db !
        }



        return response()->json(['response' => '______']);
    }




}
