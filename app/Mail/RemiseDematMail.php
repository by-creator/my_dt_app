<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RemiseDematMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $files;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $files)
    {
        $this->data = $data;
        $this->files = $files;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(
            $this->data['email'], // adresse e-mail de l’expéditeur
            strtoupper($this->data['prenom'] . ' ' . $this->data['nom']) // nom visible
        ),
            subject: 'Demande de remise - ' . $this->data['bl']
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.validation_demat',
            with: [
                'nom' => strtoupper($this->data['nom']),
                'prenom' => strtoupper($this->data['prenom']),
                'email' => $this->data['email'],
                'bl' => strtoupper($this->data['bl']),
                'compte' => strtoupper($this->data['compte']),
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

        foreach ($this->files as $file) {
            $attachments[] = Attachment::fromData(
                fn() => file_get_contents($file->getRealPath()),
                $file->getClientOriginalName()
            )->withMime($file->getMimeType());
        }

        return $attachments;
    }
}
