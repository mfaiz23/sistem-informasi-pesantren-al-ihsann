<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

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
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
                    ->subject(Lang::get('Notifikasi Reset Kata Sandi'))
                    ->line(Lang::get('Anda menerima email ini karena kami menerima permintaan reset kata sandi untuk akun Anda.'))
                    ->action(Lang::get('Reset Kata Sandi'), $resetUrl)
                    ->line(Lang::get('Tautan reset kata sandi ini akan kedaluwarsa dalam :count menit.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                    ->line(Lang::get('Jika Anda tidak merasa meminta reset kata sandi, abaikan saja email ini.'))
                    ->line('---') // Baris pemisah untuk kerapian
                    // --- Bagian yang ditambahkan ---
                    ->line(Lang::get('Jika Anda mengalami kendala, silakan hubungi kami:'))
                    ->line(Lang::get('Kontak Admin: 0812-3456-7890')) // <-- Ganti dengan nomor kontak admin yang sebenarnya
                    ->line(Lang::get('Email Yayasan: kontak@yayasanhebat.com')); // <-- Ganti dengan email yayasan yang sebenarnya
    }
}
