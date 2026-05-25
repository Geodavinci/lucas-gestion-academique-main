<?php

namespace App\Mail;

use App\Models\Memoire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CorrectionCompleteNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Memoire $memoire
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre mémoire a été révisé',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.correction-complete',
            with: [
                'memoire' => $this->memoire,
                'student' => $this->memoire->student,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
