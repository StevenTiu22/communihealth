<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public mixed $notifiable;
    public string $verificationUrl;
    /**
     * Create a new message instance.
     */
    public function __construct($notifiable, $verificationUrl)
    {
        $this->notifiable = $notifiable;
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Build the message.
     */
    public function build(): Mailable
    {
        return $this->markdown('emails.verify-email', [
            'verificationUrl' => $this->verificationUrl,
        ]);
    }
}
