<?php

namespace App\Http\Controllers\Backend;

use App\Mail\NewCommentSubscribedNotification;
use App\Http\Requests\SendCommentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentPublished;
use Illuminate\Http\Request;
use App\Subscribedtocomment;
use App\Mail\CommentSent;
use App\Comment;
use Redirect;
use App\Post;


class CmsCommentsController extends Controller {   

    public function __construct(){
        $this->middleware(['auth'])->except('send', 'subscribe'); 
    }


    public function send(SendCommentRequest $request, $slug){ 

        // 1) insert in db like DRAFT
        $post_id = Post::where('slug', $slug)->first()->id;
        $comment = new Comment;
        $comment->on_post = $post_id;  // => lo recupera da db attraverso lo slug
        $comment->from_user_name = $request->input('c-name');
        $comment->body = $request->input('c-body');
        $comment->from_user_email = $request->input('c-email');
        $comment->from_user_ip = $request->server('REMOTE_ADDR');  // approfondire !!!
        //$comment->from_user_url = $request->input(''); --> aggiungere campo url nel form commenti
        $comment->comment_approved = 0;  //draft
        $comment->comment_agent = $request->header('User-Agent');
        $comment->comment_parent = $request->input('comment_parent');
        $comment->save();

        // 2) if there's subscription flag -> insert user in subscribed_to_comments table
        if($request->input('c-subscription') == 1) {
            
            $subscribed = new Subscribedtocomment;
            $subscribed->name = $request->input('c-name');
            $subscribed->email = $request->input('c-email');
            $subscribed->post_id = $post_id;   // => lo recupera da db attraverso lo slug
            $subscribed->save();

            $subscribed->code = str_slug(bcrypt($request->input('c-email') . $subscribed->id .'&%stringaakkazzo!#@'));
            $subscribed->save();  //doppio save() per estrarre l'id autoincrement e inserirlo in bcrypt()
        }        

        // 3) invia comment ad admin per moderazione
        Mail::to(config('custom.admin_email'))->send(new CommentSent($comment));

        return redirect($slug.'#alert')->with('success_message', 'Commento inviato correttamente, ora è in attesa di moderazione.<br>Riceverai una mail quando verrà pubblicato.');
    }
    

    //l'utente si iscrive agli aggiornamenti senza lasciare alcun commento
    public function subscribe(Request $request, $slug) {
        
        // validate
        $this->validate($request, [
            'mail-subscr' => 'bail|required|email',
            ], [
            'mail-subscr.required' => 'Inserisci il tuo indirizzo e-mail.',
            'mail-subscr.email' => 'Inserisci un indirizzo email corretto.',
            ]); 

        // insert in subscribed_to_comments table
        $post_id = Post::where('slug', $slug)->first()->id;

        $subscribed = new Subscribedtocomment;
        // $subscribed->name = $request->input(''); // null
        $subscribed->email = $request->input('mail-subscr');
        $subscribed->post_id = $post_id;   // => lo recupera da db attraverso lo slug
        $subscribed->save();

        $id = $subscribed->id;
        $subscribed->code = str_slug(bcrypt($request->input('mail-subscr') . $id .'&%stringaakkazzo!#@'));

        $subscribed->save();  //doppio save() per estrarre l'id autoincrement e inserirlo in bcrypt()

        return redirect($slug .'#alert')->with('success_message', 'Ora sei iscritto/a a questa discussione.<br>Riceverai un\'e-mail quando verrà pubblicato un nuovo commento.');
    }


    // link di dis-iscrizione alla mail inviata al subscribed to comment
    public function UnsubscribeToComment($slug, $unique_code) {

        $subscriber = Subscribedtocomment::where('code', $unique_code)->first();
        $subscriber->delete();    // TODO implementare eventualmente il softdelete modificando il Model e la tabella
        return redirect($slug)->with('success_message', 'Ora non sei più iscritto agli aggiornamenti di questa discussione.');
    }


}
