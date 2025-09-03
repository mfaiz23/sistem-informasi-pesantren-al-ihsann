<?php

namespace App\Mail;

use App\Models\Formulir;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormulirVerified extends Mailable
{
    use Queueable, SerializesModels;

    public $formulir;

    /**
     * Create a new message instance.
     */
    public function __construct(Formulir $formulir)
    {
        $this->formulir = $formulir;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Dokumen Formulir Pendaftaran Santri Anda Telah Diverifikasi',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.formulir.verified',
            with: [
                'nama' => $this->formulir->nama_panggilan,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
