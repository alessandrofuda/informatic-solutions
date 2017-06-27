<?php

namespace App\Mail;

//use App\Watchinglist;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LowerPriceNotification extends Mailable
{
    use Queueable, SerializesModels;

    
    protected $name;
    protected $list;
    protected $count;
    protected $link;
    protected $link_home;
    protected $user_id;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $list, $count, $link, $link_home, $user_id)
    {
        $this->name = $name;
        $this->list = $list;
        $this->count = $count;
        $this->link = $link;
        $this->link_home = $link_home;
        $this->user_id = $user_id;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('notifiche@informatic-solutions.it', 'Informatic-solutions')
                    ->subject('Ehi ' . $this->name . '! Un oggetto che stai monitorando è sceso di prezzo..')
                    //->text('emails.comparator.lower_price_notification_plain')
                    ->view('emails.comparator.lower_price_notification')
                    ->with('name', $this->name)
                    ->with('list', $this->list)
                    ->with('count', $this->count)
                    ->with('link', $this->link)
                    ->with('link_home', $this->link_home)
                    ->with('user_id', $this->user_id);
    }
}
