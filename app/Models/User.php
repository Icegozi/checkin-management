<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Mass assignable attributes
    protected $fillable = [
        'id',
        'name',
        'email', 
        'password', 
        'role', 
        'address',
        'status', 
        'first_login',
    ];

    // Relationship with Member model (if relevant)
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
