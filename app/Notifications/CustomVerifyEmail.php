<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends Notification
{
    protected $verificationCode;

    /**
     * Create a new notification instance.
     */
    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Confirmez votre adresse email - WoodShop')
            ->view('emails.verify-email', [
                'user' => $notifiable,
                'verificationCode' => $this->verificationCode
            ]);
    }
}