<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Subscribedtocomment;
use Redirect;
use Illuminate\Support\Facades\Mail;

use App\Mail\CommentSent;
use App\Mail\CommentPublished;
use App\Mail\NewCommentSubscribedNotification;


class AdminCommentsController extends Controller {   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->slug = 'migliori prodotti';  
        $this->middleware(['auth','admin'])->except('send', 'subscribe');   // !!! CREARE MIDDLEWARE PER ADMIN, AUTHOR, SUBSCRIBER !!!
    }



    /**
     * Display a listing of the comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $comments = Comment::orderBy('created_at', 'DESC')->paginate(20);
        $origin = 'comments';
        
        return view('backend.adminCommentsList')->with('slug', $this->slug)
                                           ->with('comments', $comments)
                                           ->with('all', true)
                                           ->with('origin', $origin);
                                           
    }

    

    public function pending() {

        $comments = Comment::where('comment_approved', 0)->paginate(20);
        //dd($comments);
        $origin = 'pending-comments';
        
        return view('backend.adminCommentsList')->with('slug', $this->slug)
                                           ->with('comments', $comments)
                                           ->with('all', false)
                                           ->with('origin', $origin);                               
    }


    public function create() {
        //
    }



    public function publish(Request $request, $commentId) {

        // 1) update comment_approved on the comments table
        
        $slug = $request->origin;

        $comment = Comment::find($commentId);
        
        $comment->comment_approved = 1;
        $comment->save();
        
        // 2) send notification to comment author (and admin)
        Mail::to($comment->from_user_email)     // !!! invio mail a autore commento !!!!!!!!!!!!!!
            ->bcc(config('custom.admin_email'))
            ->send(new CommentPublished($comment));

        // 3) send notification to ALL subscribedtocomment (ESCLUSO QUESTO SOPRA!! che altrimenti riceverebbe doppia mail)
        $post_id = $comment->on_post;  //prende variabile del p.to 1)
        $subscribers = Subscribedtocomment::where('post_id', $post_id)->get(); 

        foreach ($subscribers as $subscriber) {
        
            if ($subscriber->email != $comment->from_user_email) {  // --> evita di inviare doppia notifica all'utente di cui sopra
                Mail::to($subscriber->email)->queue(new NewCommentSubscribedNotification($subscriber, $comment));  // --> IN PRODUZIONE: configurare la queue !!
            }
             
           
        }

        return redirect('admin/'. $slug)->with('success_message', 'Commento pubblicato e notifica e-mail inviata all\'autore');

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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $comment = Comment::find($id);
        return view('backend.adminCommentEdit')->with('slug', $this->slug)
                                           ->with('comment', $comment);
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
        //$this->validate($request, [ //completare !!!
        //    '' => 'bail|required|email',
        //    ]); 

        $slug = $request->origin;

        $comment = Comment::find($id);

        $comment->from_user_name = $request->input('nome');
        $comment->body = $request->input('commento');
        $comment->created_at = $request->input('scritto-il');
        $comment->comment_approved = $request->input('pubblicato') ? 1 : 0;
        
        $comment->save();
        
        return redirect('admin/'. $slug)->with('success_message', 'Commento <b>'. $comment->id .'</b> aggiornato correttamente!');
        
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {   
        $slug = $request->origin;

        $comment = Comment::find($id);
        $comment->delete();

        return redirect('admin/'. $slug)->with('success_message', 'Commento <b>'. $comment->id .'</b> eliminato correttamente (softDeletes())!');
    }



}
