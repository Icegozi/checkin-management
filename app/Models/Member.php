<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'fullname',
        'user_id',
        'nickname',
        'birthday',
        'gender',
        'phone_number',
        'email',
        'contact',
        'image_use',
        'address',
        'note'
    ];

    public function qrcodes() : HasMany{
        return $this->hasMany(Qrcode::class);
    }

    public function users() : BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class, 'member_id', 'id');
    }
}
