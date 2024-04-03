<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GurusCommentNotification extends Notification
{
    use Queueable;
protected $comments;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comments)
    {
        $this->comments = $comments;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Received comment by one of our Gurus')
            ->line('Your audition has been reviewd by one of our Gurus and you have received following comment:')
            // ->markdown('emails.gurusComment', ['payment' => $this->payment])

            ->line($this->comments);

    }
}
