<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReceiverNotification;
use App\Models\Company;
use App\Models\NotificationMedia;
use Illuminate\Support\Str;

class ReceiverNotificationSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first();
        $telegram = NotificationMedia::where('code', 'telegram')->first();
        $email = NotificationMedia::where('code', 'email')->first();

        if ($company && $telegram) {
            ReceiverNotification::create([
                'code' => Str::upper(Str::random(10)),
                'company_id' => $company->id,
                'notification_media_id' => $telegram->id,
                'contact_value' => '-100123456789', // Contoh ID Group Telegram
                'is_active' => true,
            ]);
        }

        if ($company && $email) {
            ReceiverNotification::create([
                'code' => Str::upper(Str::random(10)),
                'company_id' => $company->id,
                'notification_media_id' => $email->id,
                'contact_value' => 'admin@ews.com',
                'is_active' => true,
            ]);
        }
    }
}