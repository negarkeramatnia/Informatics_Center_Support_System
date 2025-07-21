<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Asset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * This is a more secure method and prevents errors by explicitly
     * listing the columns that can be saved to the database.
     */
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiration' => 'date',
    ];

    /**
     * Get the user that the asset is assigned to.
     */
    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    /**
     * The tickets that the asset is allocated to.
     */
    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class);
    }
}
