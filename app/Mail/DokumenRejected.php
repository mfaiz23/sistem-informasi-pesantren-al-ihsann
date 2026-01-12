<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DokumenRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $namaDokumen;

    public $alasan;

    public function __construct($user, $namaDokumen, $alasan)
    {
        $this->user = $user;
        $this->namaDokumen = $namaDokumen;
        $this->alasan = $alasan;
    }

    public function build()
    {
        return $this->subject('Pemberitahuan Penolakan Dokumen')
            ->view('emails.formulir.dokumen_rejected');
    }
}
