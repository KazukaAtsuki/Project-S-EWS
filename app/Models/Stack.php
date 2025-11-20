<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'stack_name',
        'government_code',
        'longitude',
        'latitude',
        'oxygen_reference',
    ];

    // Relasi ke Company
    public function companyRelation()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}