<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'resolution_notes',
        'priority',
    ];

    // Relationships

    // Creator of the ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Support staff assigned to the ticket
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Messages related to this ticket
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}