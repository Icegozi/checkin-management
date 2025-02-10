<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'qrcode_id',
        'member_id',
        'role',
        'fullname',
        'phone_number',
        'birthday'
    ];
    
    public function qrcodes() : BelongsTo{
        return $this->belongsTo(Qrcode::class,'qrcode_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
