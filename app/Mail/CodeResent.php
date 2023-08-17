<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodeResent extends Mailable
{
    use Queueable, SerializesModels;

    protected $from_email;

    protected $name;

    protected $numbers;

    protected $code;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $numbers, $code)
    {
        $this->from_email = 'khentiiNz@mail.com';
        $this->name = $name;
        $this->numbers = $numbers;
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->from_email, $this->name),
            subject: trans('mail.new_code'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user.newcode',
            with: [
                'name' => $this->name,
                'code' => $this->code,
                'numbers' => $this->numbers,
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
        return [];
    }
}
