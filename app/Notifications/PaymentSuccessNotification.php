<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    protected $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mm = (new MailMessage)
            ->subject('Payment Confirmation')
            ->line('Your payment was successful!')
            ->line('Thank you for your purchase.')
            ->line('Payment Details:')
            ->line('Amount: $' . ($this->payment->amount))
            ->line('Transaction ID: ' . $this->payment->payment_id);

            // TODO: Make flexible plan name instead of hardcoaded
            if($notifiable->plan == 'TNSS-S1') {
                $mm->markdown('vendor.notifications.tnsss');
            }
            else {
                $mm->markdown('vendor.notifications.tndss');
            }
            return $mm;
    }
}
