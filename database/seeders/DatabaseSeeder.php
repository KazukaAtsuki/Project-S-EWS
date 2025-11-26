<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Akun & Master Data Dasar
            UserSeeder::class,              // Membuat Admin, NOC, Operator
            NotificationMediaSeeder::class, // Membuat Web, Telegram, Email, WA
            ParameterSeeder::class,         // Membuat Parameter (CO, NO2, dll) & Threshold

            // 2. Data Simulasi Struktur EWS (Industry -> Company -> Stack)
            EwsSimulationSeeder::class,

            // 3. Konfigurasi & Relasi
            ReceiverNotificationSeeder::class, // Menghubungkan Company dengan Media Notifikasi
            NotificationSettingSeeder::class,  // Setting On/Off Notifikasi untuk Admin

            // 4. Data Dummy Grafik (Agar Monitoring Report bagus)
            MonitoringLogSeeder::class,
        ]);
    }
}