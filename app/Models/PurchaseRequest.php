<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $fillable = [
        'user_id', 'ticket_id',
        'item_name', 'quantity', 
        'estimated_price', 'url', 'reason', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}