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


class CommentsController extends Controller 
{   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->slug = 'migliori prodotti';  // valore "di default" per la variabile $slug
        $this->middleware('auth')->except('send', 'subscribe');   // !!! CREARE MIDDLEWARE PER ADMIN, AUTHOR, SUBSCRIBER !!!
    }



    /**
     * Display a listing of the comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $comments = Comment::paginate(15); // all();
        $origin = 'comments';
        
        return view('backend.comment-list')->with('slug', $this->slug)
                                           ->with('comments', $comments)
                                           ->with('all', true)
                                           ->with('origin', $origin);
                                           

    }

    

    public function pending() {

        $comments = Comment::where('comment_approved', 0)->paginate(10); //->get();
        $origin = 'pending-comments';
        
        return view('backend.comment-list')->with('slug', $this->slug)
                                           ->with('comments', $comments)
                                           ->with('all', false)
                                           ->with('origin', $origin);
                                           
                                           
    }




    public function create()
    {
        //
    }



    public function send(Request $request, $slug){ 

        // 1) validate
        $this->validate($request, [
            'c-name' => 'bail|required|max:50',
            'c-email' => 'bail|required|email',
            'c-body' => 'required|min:2|max:3000',
            'c-subscription' => 'boolean',
            'comment_parent' => 'required|integer',
            ],
            [
            'c-name.required'=>'Inserisci il tuo nome.',
            'c-name.max'=>'Il nome deve contenere al massimo :max caratteri.',
            'c-email.required'=>'Inserisci il tuo indirizzo e-mail.',
            'c-email.email'=>'Inserisci un indirizzo email corretto.',
            'c-body.required'=>'Inserisci il tuo commento.',
            'c-body.min'=>'Il testo del commento deve avere almeno :min caratteri.',
            'c-body.max'=>'Il testo del tuo commento è troppo lungo. Consentiti massimo :max caratteri.',
            ]);

        // 2) insert in db like DRAFT
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



        // 3) if there's subscription flag -> insert user in subscribed_to_comments table
        if($request->input('c-subscription') == 1) {
            
            $subscribed = new Subscribedtocomment;
            $subscribed->name = $request->input('c-name');
            $subscribed->email = $request->input('c-email');
            $subscribed->post_id = $post_id;   // => lo recupera da db attraverso lo slug

            $subscribed->save();

            $id = $subscribed->id;
            $subscribed->code = str_slug(bcrypt($request->input('c-email') . $id .'&%stringaakkazzo!#@'));

            $subscribed->save();  //doppio save() per estrarre l'id autoincrement e inserirlo in bcrypt()

        }

        

        // 4) invia comment ad admin per moderazione
        Mail::to('alessandro.fuda@gmail.com')->send(new CommentSent($comment));



        return redirect($slug.'#alert')->with('success_message', 'Commento inviato correttamente, ora è in attesa di moderazione.<br>Riceverai una mail quando verrà pubblicato.');

    }



    public function publish(Request $request, $commentId){

        // 1) update comment_approved on the comments table
        
        $slug = $request->origin;

        $comment = Comment::find($commentId);
        
        $comment->comment_approved = 1;
        $comment->save();
        
        // 2) send notification to comment author (and admin)
        Mail::to($comment->from_user_email)     // !!! invio mail a autore commento !!!!!!!!!!!!!!
            ->bcc('alessandro.fuda@gmail.com')
            ->send(new CommentPublished($comment));

        // 3) send notification to ALL subscribedtocomment (ESCLUSO QUESTO SOPRA!! che altrimenti riceverebbe doppia mail)
        $post_id = $comment->on_post;  //prende variabile del p.to 1)
        $subscribers = Subscribedtocomment::where('post_id', $post_id)->get(); 

        foreach ($subscribers as $subscriber) {
        
            if ($subscriber->email != $comment->from_user_email) {  // --> evita di inviare doppia notifica all'utente di cui sopra
                Mail::to($subscriber->email)->queue(new NewCommentSubscribedNotification($subscriber, $comment));  // --> IN PRODUZIONE: configurare la queue !!
            }
             
           
        }


        return redirect('backend/'. $slug)->with('success_message', 'Commento pubblicato e notifica e-mail inviata all\'autore');


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
        $subscriber->delete();    // implementare eventualmente il softdelete modificando il Model e la tabella

        return redirect($slug)->with('success_message', 'Ora non sei più iscritto agli aggiornamenti di questa discussione.');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $comment = Comment::find($id);
        return view('backend.comment-edit')->with('slug', $this->slug)
                                           ->with('comment', $comment);


    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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
        
        return redirect('backend/'. $slug)->with('success_message', 'Commento <b>'. $comment->id .'</b> aggiornato correttamente!');
        
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {   
        $slug = $request->origin;

        $comment = Comment::find($id);
        $comment->delete();

        return redirect('backend/'. $slug)->with('success_message', 'Commento <b>'. $comment->id .'</b> eliminato correttamente (softDeletes())!');
    }



}
