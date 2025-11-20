<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Trusur',
            'email' => 'admin@trusur.com',
            'password' => Hash::make('password123'),
            'phone' => '628123456789',
            'company' => 'PT Trusur Unggul Teknusa',
            'role' => 'Admin',
            'is_active' => true,
        ]);
    }
}