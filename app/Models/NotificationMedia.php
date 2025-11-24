<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMedia extends Model
{
    use HasFactory;

    protected $table = 'notification_medias'; // Pastikan nama tabel benar

    protected $fillable = [
        'code',
        'name',
        'description',
    ];
}