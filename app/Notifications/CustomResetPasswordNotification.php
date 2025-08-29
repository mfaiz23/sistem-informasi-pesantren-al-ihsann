<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

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
        $resetUrl = url(config('app.url').route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Menggunakan template kustom di emails/auth/reset.blade.php
        return (new MailMessage)
            ->subject('Notifikasi Reset Password')
            ->markdown('emails.auth.reset', ['url' => $resetUrl]);
    }
}
