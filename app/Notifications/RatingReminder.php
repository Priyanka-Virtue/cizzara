<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RatingReminder extends Notification
{
    use Queueable;
    protected $guru;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($guru)
    {
        $this->guru = $guru;
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
        return (new MailMessage)
                    ->line('Hello ' . $this->guru->name)
                    ->line('This is reminder for you that you have some videos pending to review. Kindly rate asap so that we can sortlist contestants.')
                    ->action('Click here to login to '.env('app_name', 'Cizzara'), url(env('app_url', 'https://cizzara.in')))
                    ->line('Thank you for being with us!');
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
