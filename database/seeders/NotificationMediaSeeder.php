<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NotificationMedia;

class NotificationMediaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['code' => 'web', 'name' => 'Web Notification', 'description' => 'Notifikasi via Dashboard Website'],
            ['code' => 'telegram', 'name' => 'Telegram', 'description' => 'Notifikasi via Bot Telegram'],
            ['code' => 'email', 'name' => 'Email', 'description' => 'Notifikasi via Email SMTP'],
            ['code' => 'whatsapp', 'name' => 'WhatsApp', 'description' => 'Notifikasi via WhatsApp Gateway'],
        ];

        foreach ($data as $item) {
            NotificationMedia::firstOrCreate(['code' => $item['code']], $item);
        }
    }
}