<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        $roleName = $this->user->role === 'konsultan' ? 'Konsultan' : 'Anggota GRCS Club';
        return new Envelope(
            subject: "Selamat! Pendaftaran Keanggotaan {$roleName} Anda Telah Disetujui - Denpasar Institute",
        );
    }

    public function content(): Content
    {
        $roleTitle = $this->user->role === 'konsultan' ? 'Konsultan Resmi' : 'Anggota GRCS Club';
        return new Content(
            view: 'emails.pendaftaran-verified',
            with: [
                'user' => $this->user,
                'roleTitle' => $roleTitle,
                'loginUrl' => route('backoffice.login'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
