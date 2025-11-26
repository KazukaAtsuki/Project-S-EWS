<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GeneralSetting;

class GeneralSettingSeeder extends Seeder
{
    public function run(): void
    {
        // Kita pakai firstOrCreate agar data cuma ada 1 baris
        GeneralSetting::firstOrCreate(
            ['id' => 1],
            [
                'site_title' => 'SAMU EWS Platform',
                'site_description' => 'Sistem Peringatan Dini & Monitoring Emisi Terintegrasi.',
                'contact_email' => 'admin@samu-ews.com',
                'contact_phone' => '+62 812 3456 7890',
                'footer_text' => '© 2025 SAMU EWS. All rights reserved.',
            ]
        );
    }
}