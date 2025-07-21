<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
    ];

    // Relationships******************
    public function ticket()//each message belongs to a ticket
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()//each message belongs to a user
    {
        return $this->belongsTo(User::class);
    }
}
