<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        // Note: 'assigned_to' is completely removed from here!
        'title',
        'description',
        'status',
        'priority',
        'category',
        'rating',
    ];

    // Relationships *************************************

    // Creator of the ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // NEW LOGIC: IT Support users assigned to the ticket (Many-to-Many)
    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ticket_user', 'ticket_id', 'user_id');
    }
    
    // Many-to-many: Ticket and the Assets
    public function allocatedAssets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class);
    }

    // Messages related to this ticket (one-to-many)
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

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'software' => 'نرم‌افزار',
            'hardware' => 'سخت‌افزار',
            'network' => 'شبکه و اینترنت',
            'access_control' => 'دسترسی و اکانت',
            'other' => 'سایر موارد',
            default => 'نامشخص',
        };
    }

    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class);
    }
}