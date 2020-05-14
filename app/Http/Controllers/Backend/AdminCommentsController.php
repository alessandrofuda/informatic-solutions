<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\storeFilterKeywordsRequest;
use App\Mail\NewCommentSubscribedNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentPublished;
use App\Subscribedtocomment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\CommentSent;
use Carbon\Carbon;
use App\Comment;
use Exception;
use App\Post;
use Redirect;
use Artisan;
use File;

class AdminCommentsController extends Controller {   

    public function __construct() {
        $this->slug = 'migliori prodotti'; 
        $this->middleware(['auth','admin'])->except('send', 'subscribe');   // !!! CREARE MIDDLEWARE PER ADMIN, AUTHOR, SUBSCRIBER !!!
        $this->spam_keywords_path = config('anti-spam-filter.storage-path'); 
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
        $comments = Comment::pending()->get(); //->paginate(20); 
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
        if (!file_exists($this->spam_keywords_path)) {
            File::put($this->spam_keywords_path, '');
        }
        $filtered_keywords_list = File::get($this->spam_keywords_path);
        return view('backend.adminCommentsFilter', ['filtered_keywords_list' => $filtered_keywords_list]);
    }


    public function runCommentsSpamFilter() {
        try {
            $deleted = $this->deleteSpamComments();
            
        } catch (Exception $e) {
            return back()->with('error_message', "Errore durante l'esecuzione del filtro anti-spam. Commenti non ripuliti. ".$e->getMessage());
        }  
        return back()->with('success_message', 'Filtro anti spam eseguito correttamente. '.$deleted.' commenti eliminati.');
    }


    public function storeFilterKeywords(storeFilterKeywordsRequest $request) {
        try { // storage file, not db
            $file = File::put($this->spam_keywords_path, trim($request->input('keywords-list')));
            if (!$file) {
                throw new Exception("Si è verificato un errore durante la creazione/scrittura di ".$this->spam_keywords_path, 1);
            }
            $response = 'La lista delle Spam-Keywords è stata aggiornata correttamente';
        } catch (Exception $e) {
            $response = $e->getMessage();    
        }
        return back()->with('success_message', $response);
    }


    public function deleteSpamComments() {
        
        $to_delete_comments = []; 
        $month_ago = Carbon::now()->subMonth();
        $pending_comments = Comment::withTrashed()->pending()->whereDate('created_at','<', $month_ago)->get();

        foreach ($pending_comments as $pending_comment) {
            if (Str::contains( strtolower($pending_comment->body), $this->getSpamKeywords() )) {
                $to_delete_comments[] = $pending_comment->id; 
            }
        }
        $deleted = Comment::withTrashed()->whereIn('id', $to_delete_comments)->forceDelete();  

        return $deleted;
    }


    public function getSpamKeywords():array {

        $spam_keywords = [];

        if (file_exists($this->spam_keywords_path)) {

            $spam_keywords_list = File::get($this->spam_keywords_path);
            $spam_keywords_expl = explode(',', $spam_keywords_list);

            foreach ($spam_keywords_expl as $spam_keyword) {
                $spam_keywords[] = strtolower(trim($spam_keyword));
            }
        }
        
        return $spam_keywords;
    }

}
