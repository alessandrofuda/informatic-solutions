<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Comment;


class CommentSent extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * The comment instance.
     *
     * @var Comment
     */
    public $comment;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->from('comments@informatic-solutions.it', 'Commenti - Informatic-solutions')
                    ->subject('Informatic-Solutions: nuovo commento da '. $this->comment->from_user_name)
                    // ->text('') // plain text email
                    ->view('emails.new_comment_notification');
    }
}
