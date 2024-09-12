<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfficerRegistrationApproved extends Notification
{
    use Queueable;

    protected $officer;

    /**
     * Create a new notification instance.
     *
     * @param $officer
     */
    public function __construct($officer)
    {
        $this->officer = $officer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Officer Registration Approved')
            ->greeting('Hello ' . $this->officer->name . ',')
            ->line('Your registration as an officer has been approved by the admin.')
            ->line('You can now log in and access your account.')
            ->action('Login', url('/officer/login'))
            ->line('Thank you for your dedication to our organization!');
    }
}
