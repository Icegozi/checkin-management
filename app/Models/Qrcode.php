<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Qrcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'qr_image',
        'expried_time',
        'member_id'
    ];

    public function members() : BelongsTo{
        return $this->belongsTo(Member::class,'member_id');
    }

    public function checkins() : HasMany{
        return $this->hasMany(Checkin::class);
    }
}
