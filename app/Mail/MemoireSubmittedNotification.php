<?php

namespace App\Mail;

use App\Models\Memoire;
use App\Models\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemoireSubmittedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Memoire $memoire,
        public Teacher $director
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouveau mémoire à réviser - ' . $this->memoire->titre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.memoire-submitted',
            with: [
                'director' => $this->director,
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
