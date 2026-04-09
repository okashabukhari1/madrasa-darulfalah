<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otpCode;
    public $userName;

    public function __construct(string $otpCode, string $userName)
    {
        $this->otpCode = $otpCode;
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password Reset OTP Code - Madrasa Dar-ul-Falah',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
