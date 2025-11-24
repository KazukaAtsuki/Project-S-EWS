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

    /**
     * FUNCTION BARU: hasRole
     */
    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }
        return $this->role === $roles;
    }

    // --- Helper Bawaan Anda ---

    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isNOC(): bool
    {
        return $this->role === 'NOC';
    }

    public function isCEMSOperator(): bool
    {
        return $this->role === 'CEMS Operator';
    }
}