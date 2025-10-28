<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;


class ValidationIesMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $bl,
        public string $compte,
        public array $documents = [],
        public array $fileNames = [],
        public string $expediteurEmail,
        public string $expediteurNom
    ) {}

    /**
     * Get the message envelope.
     */
   public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            from: new \Illuminate\Mail\Mailables\Address($this->expediteurEmail, $this->expediteurNom),
            replyTo: [new \Illuminate\Mail\Mailables\Address($this->expediteurEmail, $this->expediteurNom)],
            subject: 'Demande de validation - ' . $this->bl,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.validation_ies',
            with: [
                'bl' => $this->bl,
                'compte' => $this->compte,
                'fileNames' => $this->fileNames,
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
        $attachments = [];

        foreach ($this->documents as $index => $doc) {
            $nom = $this->fileNames[$index] ?? basename($doc);

            $attachments[] = Attachment::fromPath($doc)
                ->as($nom);
        }

        return $attachments;
    }
}
