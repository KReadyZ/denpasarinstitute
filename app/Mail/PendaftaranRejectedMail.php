<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PendaftaranRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $reason;

    public function __construct(User $user, string $reason = '')
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        $roleName = $this->user->role === 'konsultan' ? 'Konsultan' : 'Anggota GRCS Club';
        return new Envelope(
            subject: "Pemberitahuan Status Pendaftaran Keanggotaan {$roleName} - Denpasar Institute",
        );
    }

    public function content(): Content
    {
        $roleTitle = $this->user->role === 'konsultan' ? 'Konsultan' : 'Anggota GRCS Club';
        return new Content(
            view: 'emails.pendaftaran-rejected',
            with: [
                'user' => $this->user,
                'roleTitle' => $roleTitle,
                'reason' => $this->reason,
                'registerUrl' => $this->user->role === 'konsultan' ? route('pendaftaran.konsultan') : route('pendaftaran.grcs'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
