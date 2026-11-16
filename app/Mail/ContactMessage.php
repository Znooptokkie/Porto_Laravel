<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The subject is fixed so that user input never ends up in a mail header.
     */
    public function __construct(
        public string $senderName,
        public string $senderEmail,
        public string $body,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nieuw bericht via de website',
            replyTo: [$this->senderEmail],
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.contact-message');
    }
}
