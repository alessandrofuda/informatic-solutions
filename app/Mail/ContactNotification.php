<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Informatic-solutions.it, richiesta per: ' . $this->request->servizio;

        return $this->from('contact-form@informatic-solutions.it', 'Informatic-Solutions')
                    ->subject($subject) 
                    ->view('emails.homepage_contact_notification');
    }
}
