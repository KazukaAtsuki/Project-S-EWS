<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_title',
        'site_description',
        'contact_email',
        'contact_phone',
        'footer_text',
        'app_logo',
    ];
}