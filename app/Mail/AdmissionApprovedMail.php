<?php

namespace App\Mail;

use App\Models\Admission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdmissionApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Admission $admission;

    public function __construct(Admission $admission)
    {
        $this->admission = $admission;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Selamat! Pendaftaran Program Anda Telah Disetujui - Denpasar Institute",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admission-approved',
            with: [
                'admission'    => $this->admission,
                'programNames' => $this->admission->programs->pluck('nama')->implode(', ') ?: 'Program Kursus Denpasar Institute',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

