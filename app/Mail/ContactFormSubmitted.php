<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    public function build()
    {
        return $this->subject('New Contact Form Submission - WTG?')
                    ->view('emails.contact-form')
                    ->replyTo($this->contactData['email'], $this->contactData['first_name'] . ' ' . $this->contactData['last_name']);
    }
}