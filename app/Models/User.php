<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;//one-to-many
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'profile_picture',
        'department',
        'last_login',
        'theme',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',//convert it to datatime for jalali...
            'password' => 'hashed',//before saving in database
            'last_login' => 'datetime',
        ];
    }

    public function tickets(): HasMany//one to many    user and tickets
    {
        return $this->hasMany(Ticket::class);
    }
    public function assets(): HasMany//one to many 
    {
        return $this->hasMany(Asset::class, 'assigned_to');//not default user_id
    }

    public function assignedTickets()//for IT support
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
