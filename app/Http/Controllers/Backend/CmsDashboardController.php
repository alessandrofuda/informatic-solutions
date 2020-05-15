<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\changeArticleStatusRequest;
use App\Http\Requests\saveArticleSlugRequest;
use App\Http\Requests\SaveArticleRequest;
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

    public function index() {

        $user = Auth::user();
        $articles = Post::paginate(15);
        $lastArticleId = Post::select('id')->orderBy('id', 'DESC')->first()->id;
        $newArticleId = (int)++$lastArticleId;

        if (session()->get('article_id')) {
            $newArticleId = session()->get('article_id');
        }

        return view('backend.cmsHome')->with('user', $user)
                                      ->with('articles', $articles)
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
        // return count(Post::where('slug', $slug)->get()) > 0 ? true : false;
    }

    public function postAlreadyInDb($id) {
        return Post::find($id) ? true : false;
    }

    public function saveArticleSlug(saveArticleSlugRequest $request) {

        $rawslug = trim($request->input('slug')) ? : null;
        $slug = $rawslug ? $this->sanitizeSlug($rawslug) : null;
        $status = null;
        $post_id = $request->input('id');

        $params = ['slug' => $slug];
        if (Auth::user()->is_author() || (Auth::user()->is_admin() && !$this->postAlreadyInDb($post_id))) {
            $params['author_id'] = Auth::user()->id;
        }

        $article = Post::updateOrCreate(['id' => $post_id], $params);

        if($article->wasRecentlyCreated){
            $response = 'Nuova Url salvata correttamente';
        } else {
            $response = 'Url aggiornata correttamente (Id articolo: '.$post_id.')';
        }
        
        return response()->json(['response' => $response , 'status' => $status, 'slug' => $slug ]);
    }


    public function saveArticle(SaveArticleRequest $request, $with_status_definition = null) {
        
        $rawslug = trim($request->input('slug')) ? : null;
        $slug = $rawslug ? $this->sanitizeSlug($rawslug) : null;
        $post_id = $request->input('id');

        $params = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'body' => $request->input('body'),
            'slug' => $slug, 
            'active' => $request->input('published') ? Post::STATUS['published'] : Post::STATUS['not_published']
        ];
        if (Auth::user()->is_author() || (Auth::user()->is_admin() && !$this->postAlreadyInDb($post_id))) {
            $params['author_id'] = Auth::user()->id;
        }

        $article = Post::updateOrCreate(['id' => $post_id], $params);

        $request->session()->put('article_id', $post_id);
        
        if($article->wasRecentlyCreated) {
            $response = 'Nuovo articolo salvato correttamente';
            if ($with_status_definition) {
                $response = $request->input('published') == Post::STATUS['published'] ? 'Nuovo articolo salvato e pubblicato' : 'Articolo Spubblicato';
            }
        } else {
            $response = 'Articolo correttamente aggiornato.';
            if ($with_status_definition) {
                $response = $request->input('published') == Post::STATUS['published'] ? 'Articolo aggiornato e pubblicato' : 'Articolo Spubblicato';
             } 
        }

        return response()->json(['response' => $response]);
    }


    /*public function changeArticleStatus(changeArticleStatusRequest $request) {
        dd($request);
        $status = $request->input('published') == 'true' ? Post::STATUS['published'] : Post::STATUS['not_published'];
        $article_id = $request->input('article_id');
        $article = Post::find($article_id);
        if ($article) {
            $article->update(['active' => $status]);
            $response = 'Articolo pubblicato!';
        } 

        return response()->json(['response'=> $response]);
    }*/

    public function makeNewArticle() {

        session()->forget('article_id');

        return redirect()->route('cms-backend.home');
    }
}
