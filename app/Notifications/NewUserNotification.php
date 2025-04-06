<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Perfume Shop')
            ->line('Hello ' . $notifiable->name . '!')
            ->line('Your account has been created successfully.')
            ->line('Your email: ' . $notifiable->email)
            ->line('Thank you for joining us!');
    }
}
