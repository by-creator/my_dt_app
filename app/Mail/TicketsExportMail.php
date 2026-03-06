<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketsExportMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $date;

    public function __construct(string $date)
    {
        $this->date = Carbon::createFromFormat('d-m-Y', $date)->format('d-m-Y');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Monitoring de la GFA du {$this->date}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tickets.export',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
