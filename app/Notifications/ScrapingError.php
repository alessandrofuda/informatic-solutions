<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ScrapingError extends Notification
{
    use Queueable;

    public $errorTitle;
    public $errorMessage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($errorTitle, $errorMessage)
    {
        $this->errorTitle = $errorTitle;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {   
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   

        // dd($notifiable);
        return (new MailMessage)
                    ->error()
                    ->subject('Scraping Error - '.$this->errorTitle)
                    ->greeting("Hello Admin,")
                    ->line('The Informatic Solutions Scraping Crawler failed.')
                    ->line('This is the Log of the error:')
                    ->line($this->errorMessage)
                    ->line('See /storage/logs/laravel.log on the server for more details.')
                    ->action('Go to site', url('/'))
                    ->line('Bye!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
