<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiverNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'company_id',
        'notification_media_id',
        'contact_value',
        'is_active',
    ];

    // Relasi ke Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Relasi ke Media
    public function media()
    {
        return $this->belongsTo(NotificationMedia::class, 'notification_media_id');
    }
}