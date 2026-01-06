<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewTicketCreated extends Notification
{
    use Queueable;

    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['database']; // Store in DB
    }

    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => 'تیکت جدید: ' . $this->ticket->title,
            'message' => 'کاربر ' . $this->ticket->user->name . ' یک تیکت جدید ثبت کرد.',
            'url' => route('tickets.show', $this->ticket->id),
            'type' => 'ticket_new'
        ];
    }
}