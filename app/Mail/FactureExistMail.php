<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FactureExistMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $bl, $nom, $prenom, $motif;

    /**
     * Create a new message instance.
     */
    public function __construct($bl, $nom, $prenom, $motif)
    {
        $this->bl = $bl;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->motif = $motif;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Facture Définitive Indisponible BL - ' . $this->bl,
        );
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.facture_exist',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
