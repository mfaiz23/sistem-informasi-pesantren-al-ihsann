<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmail extends VerifyEmailBase
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            // Ganti teks di bawah ini sesuai keinginan Anda
            ->subject(Lang::get('Verifikasi Alamat Email Anda'))
            ->line(Lang::get('Selamat datang! Mohon klik tombol di bawah untuk memverifikasi alamat email Anda.'))
            ->action(Lang::get('Verifikasi Email'), $verificationUrl)
            ->line(Lang::get('Jika Anda tidak merasa membuat akun ini, Anda dapat mengabaikan email ini.'));
    }
}
