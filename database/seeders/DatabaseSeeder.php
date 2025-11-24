<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder berurutan
        $this->call([
            UserSeeder::class,          // 1. Bikin Akun Login
            EwsSimulationSeeder::class, // 2. Bikin Company & Stack
            ParameterSeeder::class,  // 3. Bikin Parameter (Jika file ini ada, uncomment)
        ]);
    }
}
