<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun ADMIN (Untuk kelola Master Data)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ews.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'Admin',
            'company' => 'PT Trusur Internal',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        // 2. Akun NOC (Untuk Monitoring & Support)
        User::create([
            'name' => 'Staff NOC',
            'email' => 'noc@ews.com',
            'password' => Hash::make('password'),
            'role' => 'NOC',
            'company' => 'PT Trusur Internal',
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        // 3. Akun Operator (Hanya bisa lapor tiket)
        User::create([
            'name' => 'Operator Lapangan',
            'email' => 'operator@ews.com',
            'password' => Hash::make('password'),
            'role' => 'CEMS Operator',
            'company' => 'PT Simulasi EWS',
            'phone' => '081234567892',
            'is_active' => true,
        ]);
    }
}