<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyProgressNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $student;
    public $attendance;
    public $progressLog;
    public $date;

    public function __construct($student, $attendance, $progressLog, $date)
    {
        $this->student = $student;
        $this->attendance = $attendance;
        $this->progressLog = $progressLog;
        $this->date = $date;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Daily Madrasa Update: ' . ($this->student->user->name ?? 'Student'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily_progress',
        );
    }
}
