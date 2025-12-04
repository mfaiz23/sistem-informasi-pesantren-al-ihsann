<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DokumenVerified extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $namaDokumen;

    // Terima data user dan nama dokumen (misal: "KTP")
    public function __construct($user, $namaDokumen)
    {
        $this->user = $user;
        $this->namaDokumen = $namaDokumen;
    }

    public function build()
    {
        // Pastikan Anda membuat view ini nanti di Langkah 3
        return $this->subject('Verifikasi Dokumen Berhasil')
            ->view('emails.formulir.dokumen_verified');
    }
}
