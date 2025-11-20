<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'company',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Scope untuk filter berdasarkan role
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Check if user is admin
    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    // Check if user is NOC
    public function isNOC(): bool
    {
        return $this->role === 'NOC';
    }

    // Check if user is CEMS Operator
    public function isCEMSOperator(): bool
    {
        return $this->role === 'CEMS Operator';
    }
}