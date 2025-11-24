<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stack_id',
        'priority_id',
        'category_id',
        'subject',
        'description',
        'attachment',
        'status',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stack()
    {
        return $this->belongsTo(Stack::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}