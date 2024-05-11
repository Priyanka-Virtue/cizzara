<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(60),
                    ['id' => auth()->user()->id, 'hash' => sha1($notifiable->email_verification_token)]
                );
        // Customize the mail message here
        return (new MailMessage)
            ->line('Click the button below to verify your email address:')
            ->action('Verify Email', $url)
            ->from('audition@theunitedproduction.com', 'TUP');
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
