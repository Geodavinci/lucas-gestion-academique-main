<?php

namespace App\Mail;

use App\Models\Soutenance;
use App\Models\Teacher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JuryAssignedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Soutenance $soutenance,
        public Teacher $teacher
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vous êtes assigné à un jury de soutenance',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.jury-assigned',
            with: [
                'teacher' => $this->teacher,
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
