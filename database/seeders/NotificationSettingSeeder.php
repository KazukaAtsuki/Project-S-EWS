<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationSetting;

class NotificationSettingSeeder extends Seeder
{
    public function run(): void
    {
        NotificationSetting::firstOrCreate(
            ['event_name' => 'new_ticket_created'],
            [
                'description' => 'Notifikasi saat ada Tiket/Laporan Baru dari Client',
                'email_enabled' => true,
                'telegram_enabled' => true, // Default aktif
                'whatsapp_enabled' => false,
            ]
        );

        NotificationSetting::firstOrCreate(
            ['event_name' => 'ews_alert_triggered'],
            [
                'description' => 'Notifikasi saat sensor mendeteksi bahaya (EWS)',
                'email_enabled' => false,
                'telegram_enabled' => true,
                'whatsapp_enabled' => false,
            ]
        );
    }
}