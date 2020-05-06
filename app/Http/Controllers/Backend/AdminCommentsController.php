<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\storeFilterKeywordsRequest;
use App\Mail\NewCommentSubscribedNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentPublished;
use App\Subscribedtocomment;
use Illuminate\Http\Request;
use App\Mail\CommentSent;
use App\Comment;
use App\Post;
use Redirect;
use File;

class AdminCommentsController extends Controller {   

    public function __construct() {
        $this->slug = 'migliori prodotti';  
        $this->middleware(['auth','admin'])->except('send', 'subscribe');   // !!! CREARE MIDDLEWARE PER ADMIN, AUTHOR, SUBSCRIBER !!!
    }

    public function index() {

        $comments = Comment::orderBy('created_at', 'DESC')->paginate(20);
        $origin = 'comments';
        
        return view('backend.adminCommentsList')->with('slug', $this->slug)
                                           ->with('comments', $comments)
                                           ->with('all', true)
                                           ->with('origin', $origin);    
    }

    public function pending() {
        $comments = Comment::pending()->paginate(20); 
        $origin = 'pending-comments';
        return view('backend.adminCommentsList')->with('slug', $this->slug)
                                           ->with('comments', $comments)
                                           ->with('all', false)
                                           ->with('origin', $origin);                               
    }

    public function publish(Request $request, $commentId) {

        // 1) update comment_approved on the comments table
        $slug = $request->origin;
        $comment = Comment::find($commentId);
        $comment->comment_approved = Comment::STATUS['APPROVED'];
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


    public function edit($id) {
        $comment = Comment::find($id);
        return view('backend.adminCommentEdit')->with('slug', $this->slug)
                                               ->with('comment', $comment);
    }

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


    public function destroy(Request $request, $id) {   
        $slug = $request->origin;
        $comment = Comment::find($id);
        $comment->delete();
        return redirect('admin/'. $slug)->with('success_message', 'Commento <b>'. $comment->id .'</b> eliminato correttamente (softDeletes())!');
    }


    public function filter() {

        $filtered_keywords_list = File::get(storage_path('app/config/comments-spam/filtered-keywords-list.txt'));
        return view('backend.adminCommentsFilter', ['filtered_keywords_list' => $filtered_keywords_list]);
    }


    public function storeFilterKeywords(storeFilterKeywordsRequest $request) {

        try {
            $file = File::put(storage_path('app/config/comments-spam/filtered-keywords-list.txt'), trim($request->input('keywords-list')) );  // 
            if (!$file) {
                throw new Exception("Error Processing Request", 1);
            }
        } catch (Exception $e) {
            $response = 'Si è verificato un errore durante la creazione/scrittura del file';    
        }
        
        $response = 'La lista della Keywords-Filtro è stata aggiornata correttamente';

        return back()->with('success_message', $response);
    }



}
