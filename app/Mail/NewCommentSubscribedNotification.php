<?php

namespace App\Mail;

use App\Subscribedtocomment;
use App\Comment;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class NewCommentSubscribedNotification extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * The order instance.
     *
     * @var Subscriber
     */
    public $subscriber;
    public $comment;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscribedtocomment $subscriber, Comment $comment)
    {
        $this->subscriber = $subscriber;
        $this->comment = $comment;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if( $this->subscriber->name == null ){

            $subject = 'Ciao, ci sono aggiornamenti da una discussione che segui';

        } else {

            $subject = $this->subscriber->name . ', ci sono aggiornamenti da una discussione che segui';
            
        }
 
        return $this->from('notifiche@informatic-solutions.it', 'Notifiche - informatic-solutions')
                    ->subject($subject)
                    ->view('emails.new_comment_subscribed_notification');
        
    }
}
