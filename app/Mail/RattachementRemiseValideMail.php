<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RattachementRemiseValideMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bl, $nom, $prenom, $date, $pourcentage;

    /**
     * Create a new message instance.
     */
    public function __construct($bl, $nom, $prenom, $date, $pourcentage)
    {
        $this->bl = $bl;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date = $date;
        $this->pourcentage = $pourcentage;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Demande de remise validée BL - ' . $this->bl,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.rattachement_remise_valide',
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
