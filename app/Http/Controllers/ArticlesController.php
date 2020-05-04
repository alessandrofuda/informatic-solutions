<?php

namespace App\Http\Controllers;

//use App\Subscribedtocomment;
use Illuminate\Http\Request;
use App\Comment;
use App\Rating;
use App\Post;



class ArticlesController extends Controller {

    public function __construct() {
        $this->page_type = 'cms';
    }

    public function index($slug) {

        $post = Post::where('slug',$slug)->get()->first() ?? abort(404); 
        $comments = Comment::parent()->approved()->get();      							
        $comments_child = Comment::child()->approved()->get();                   	
        $total_comments = count($comments) + count($comments_child);
        
        // rating system - TODO
        $moltiplicator = 848;
        $numero_voti = Rating::where('post_id', $post->id)->count();
        $numero_voti = $numero_voti + (5 * $moltiplicator);
        // $sum = intval(Rating::where('post_id', $post_id)->sum('rate'));
        $voto_medio = 5; //ceil($sum / $numero_voti);        
    	
    	return view('videocitofoni')->with('post', $post)
                                    ->with('comments', $comments)
    								->with('comments_child', $comments_child)
                                    ->with('total_comments', $total_comments)
                                    ->with('voto_medio', $voto_medio)
                                    ->with('numero_voti', $numero_voti)
                                    ->with('page_type', $this->page_type);
    }


    public function rating(Request $request) {  // TODO

        $date = date('D d M Y'); 
        $ipaddress = $_SERVER['REMOTE_ADDR']; // here I am taking IP as UniqueID but you can have user_id from Database or 
        $unique_day_key = md5($ipaddress.$date);

        // validate form
        $this->validate($request, [
            'rate' => 'required|integer|between:1,5',
            'post_id' => 'required|integer',
        ]);

        $rate = $request->rate;
        $post_rated_id = $request->post_id;

        // search for duplicate
        $duplicate = Rating::where('user_id', $unique_day_key)->where('post_id', $post_rated_id)->get();

        if(count($duplicate) > 0) {

            // NOT insert, return id of duplicate 
            $d = $duplicate->first()->id;

        } else {

            // insert and return 0
            if( $newVote = Rating::create([
                    'rate' => $rate,
                    'post_id' => $post_rated_id,
                    'user_id' => $unique_day_key,
                ]) ) {

                $d = 0;
            }
        }

        return $d;
    }



}
