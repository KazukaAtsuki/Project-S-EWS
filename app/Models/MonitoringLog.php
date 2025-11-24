<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringLog extends Model
{
    use HasFactory;

    protected $fillable = ['stack_id', 'parameter_id', 'value'];

    // Relasi ke Stack
    public function stack()
    {
        return $this->belongsTo(Stack::class, 'stack_id');
    }

    // Relasi ke Parameter
    public function parameter()
    {
        return $this->belongsTo(Parameter::class, 'parameter_id');
    }
}