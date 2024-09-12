<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegistrationPending extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Thank you for registering with us!')
                    ->line('Your registration is currently under review by an administrator.')
                    ->line('We will notify you once your account is approved and activated.')
                    ->line('If you have any questions, please contact support.')
                    ->action('Contact Support', url('/contact'))
                    ->line('Thank you for your patience!');
    }
}
