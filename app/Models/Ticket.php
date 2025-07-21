<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
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

    public function getJalaliCreatedAtAttribute(): string
    {
        return Jalalian::fromCarbon($this->created_at)->format('%A, %d %B %Y - H:i');
    }

    public function getJalaliUpdatedAtAttribute(): string
    {
        return Jalalian::fromCarbon($this->updated_at)->format('%A, %d %B %Y - H:i');
    }
    /**
     * The assets that are allocated to the ticket.
     */
    public function allocatedAssets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class);
    }
}