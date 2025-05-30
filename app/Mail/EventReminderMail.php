<?php

namespace App\Mail;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function build()
    {
        return $this->subject($this->notification->title)
                    ->view('emails.event-reminder')
                    ->with([
                        'notification' => $this->notification,
                        'event' => $this->notification->savedEvent,
                        'user' => $this->notification->account
                    ]);
    }
}