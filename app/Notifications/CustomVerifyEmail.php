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
            ->subject(Lang::get('Verifikasi Alamat Email Anda'))
            ->greeting('Assalamualaikum, Calon Santri!')
            ->line(Lang::get('Terima kasih sudah mendaftar. Mohon klik tombol di bawah untuk memverifikasi alamat email Anda.'))
            ->action(Lang::get('Verifikasi Email'), $verificationUrl)
            ->line(Lang::get('Jika Anda tidak merasa membuat akun ini, Anda dapat mengabaikan email ini.'))
            ->salutation('Hormat kami, PSB Al-Ihsan');
    }
}
