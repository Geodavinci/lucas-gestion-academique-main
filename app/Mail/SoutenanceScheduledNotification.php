<?php

namespace App\Mail;

use App\Models\Soutenance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SoutenanceScheduledNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Soutenance $soutenance
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre soutenance est programmée',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.soutenance-scheduled',
            with: [
                'soutenance' => $this->soutenance,
                'student' => $this->soutenance->student,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
