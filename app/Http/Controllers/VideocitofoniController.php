<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
//use App\Subscribedtocomment;

class VideocitofoniController extends Controller
{

    public function index() {

        $id = 2; //id del post su: "videocitofoni, come scegliere il miglior rapp...."
        $post = Post::findOrFail($id);
    	$comments = Comment::where('comment_parent', 0)
    							->where('comment_approved', 1)
    							->get();    							
    	$comments_child = Comment::where('comment_parent', '>', 0)
    								->where('comment_approved', 1)
    								->get();    	
        $tot = count($comments) + count($comments_child);

        //$subs = Subscribedtocomment::all();
        //dd($subs[0]->post()->name);

    	
    	return view('videocitofoni')->with('post', $post)
                                    ->with('comments', $comments)
    								->with('comments_child', $comments_child)
                                    ->with('tot', $tot);

    }

}
