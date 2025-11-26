<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_code',
        'name',
        'industry_id',
        'contact_person',
        'contact_phone',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relationship dengan Industry
    public function industryRelation()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }
}