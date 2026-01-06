<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTicketReply extends Notification
{
    use Queueable;

    public $ticket;
    public $senderName;

    public function __construct($ticket, $senderName)
    {
        $this->ticket = $ticket;
        $this->senderName = $senderName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => 'پاسخ جدید در تیکت #' . $this->ticket->id,
            'message' => $this->senderName . ' به تیکت شما پاسخ داد.',
            'url' => route('tickets.show', $this->ticket->id),
            'type' => 'ticket_reply'
        ];
    }
}