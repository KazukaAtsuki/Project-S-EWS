<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EwsAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Variable penampung data

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🚨 EWS ALERT: Threshold Exceeded - ' . $this->data['stack_name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ews-alert', // Kita akan buat view ini nanti
        );
    }
}