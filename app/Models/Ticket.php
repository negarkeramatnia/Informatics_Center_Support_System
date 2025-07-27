<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;//many-to-many

class Ticket extends Model
{

    protected $fillable = [
        'user_id',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
        'rating',
    ];

    // Relationships*************************************

    // Creator of the ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // IT Support assigned to the ticket
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    
    //many-to-many
    //Ticket and the Assets
    public function allocatedAssets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class);
    }

    // Messages related to this ticket 
    // one-to-many
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getJalaliCreatedAtAttribute(): string
    {
        return Jalalian::fromCarbon($this->created_at)->format('%A, %d %B %Y - H:i');
    }

    public function getJalaliUpdatedAtAttribute(): string
    {
        return Jalalian::fromCarbon($this->updated_at)->format('%A, %d %B %Y - H:i');
    }

    public function allocatedAssets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class);
    }
}