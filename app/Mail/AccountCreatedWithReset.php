<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountCreatedWithReset extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $resetUrl,
        public string $role
    ) {}

    public function envelope(): Envelope
    {
        $roleLabel = match ($this->role) {
            'teacher' => 'Enseignant',
            'student' => 'Étudiant',
            default => 'Utilisateur'
        };

        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: "Votre compte $roleLabel a été créé - Définissez votre mot de passe",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.account-created',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'resetUrl' => $this->resetUrl,
                'role' => $this->role,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
