<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'serial_number',
        'purchase_date',
        'warranty_expiration',
        'status',
        'location',
        'assigned_to',
    ];

    // Relationship: Asset is assigned to a User
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}