<?php

namespace App\Http\Controllers\Backend;


use App\Http\Requests\saveArticleSlugRequest;
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
        // return int
        return count(Post::where('slug', $slug)->get()); 
        //return count(Post::where('slug', $slug)->get()) > 0 ? true : false;
    }



    public function saveArticleSlug(saveArticleSlugRequest $request) {

        $rawslug = trim($request->input('slug')) ? : null;
        $slug = $rawslug ? $this->sanitizeSlug($rawslug) : null;
        $status = null;

        $data = ['slug' => $slug];
        if (Auth::user()->is_author()) {
            $data['author_id'] = Auth::user()->id;
        }

        $article = Post::updateOrCreate(['id' => $request->input('id')], $data);

        if($article->wasRecentlyCreated){
            $response = 'Nuova Url salvata correttamente';
        } else {
            $response = 'Url aggiornata correttamente (Id articolo: '.$request->input('id').')';
        }
        
        return response()->json(['response' => $response , 'status' => $status, 'slug' => $slug ]);
    }


    public function saveArticle(Request $request) {

        $validator = Validator::make($request->all(), [
            'slug' => 'required|max:300',
            'title' => 'required|max:300',
        ])->validate();

        
        $rawslug = trim($request->input('slug')) ? : null;
        $slug = $rawslug ? $this->sanitizeSlug($rawslug) : null;
         

        $params = [
            'author_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'body' => $request->input('body'),
            'slug' => $slug, 
            // 'images' => $request->input(''),
            'active' => $request->input('published') ? : 0,
        ];

        $article = Post::updateOrCreate(['id' => $request->input('id')], $params);
        
        if($article->wasRecentlyCreated) {

            if($this->slugAlreadyInDb($article->slug) > 1 ) { // check: slug SANITIZZATO esiste GIÀ ?
                $article->update(['slug' => $article->slug.'-duplicatedSlug-'.rand(0,900)]);  // update db !
                $response = 'Nuovo articolo salvato correttamente (slug aggiornato).';   
            }

            $response = 'Nuovo articolo salvato correttamente';
        
        } else {

            if($this->slugAlreadyInDb($article->slug) > 1 ) { // check: slug SANITIZZATO esiste GIÀ ?
                $article->update(['slug' => $article->slug.'-duplicatedSlug-'.rand(0,900)]);  // update db !
                $response = 'Articolo correttamente aggiornato, ma la Url è stata modificata perchè era già presente in database.';   
            }

            $response = 'Articolo correttamente aggiornato.'; 
        }

        return response()->json(['response' => $response]);
    }

}
