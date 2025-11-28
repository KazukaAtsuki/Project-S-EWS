<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stack;
use App\Models\MonitoringLog;
use App\Models\ReceiverNotification;
use App\Models\NotificationSetting;
use App\Services\TelegramService;
use Carbon\Carbon;

class CheckDeviceActivity extends Command
{
    protected $signature = 'ews:check-status'; // Nama perintah baru
    protected $description = 'Cek status Abnormal, Overrange, dan Data Not Sent';

    public function handle()
    {
        $this->info('Memulai pengecekan EWS...');

        // Ambil settingan notifikasi dulu
        $settingAlert = NotificationSetting::where('event_name', 'ews_alert_triggered')->first();

        // Jika setting dimatikan admin, stop.
        if (!$settingAlert || !$settingAlert->telegram_enabled) {
            $this->info('Notifikasi Telegram dimatikan di setting.');
            return;
        }

        $stacks = Stack::all();

        foreach ($stacks as $stack) {
            // Ambil log terakhir dari stack ini
            // Kita juga butuh data parameter untuk cek ambang batas
            $lastLog = MonitoringLog::with('parameter')
                        ->where('stack_id', $stack->id)
                        ->latest()
                        ->first();

            // ====================================================
            // KONDISI 1: DATA NOT SENT (Offline > 5 Menit)
            // ====================================================
            $fiveMinutesAgo = Carbon::now()->subMinutes(5);

            if (!$lastLog || $lastLog->created_at < $fiveMinutesAgo) {
                $lastSeen = $lastLog ? $lastLog->created_at->format('H:i:s d/m/Y') : 'Never';

                $msg  = "<b>⚠️ EWS ALERT: DATA NOT SENT</b>\n";
                $msg .= "──────────────────────\n";
                $msg .= "🏭 <b>" . ($stack->companyRelation->name ?? '-') . "</b>\n";
                $msg .= "📍 <i>{$stack->stack_name} ({$stack->government_code})</i>\n";
                $msg .= "📉 <b>Status:</b> OFFLINE / NO SIGNAL\n";
                $msg .= "⏳ <b>Last Data:</b> {$lastSeen}\n";
                $msg .= "──────────────────────\n";
                $msg .= "🛠 <i>Mohon cek koneksi internet atau power sensor!</i>";

                $this->sendNotification($stack->company_id, $msg);
                continue; // Lanjut ke stack berikutnya, gak perlu cek nilai
            }

            // ====================================================
            // KONDISI 2: CEK NILAI (Abnormal / Overrange / Baku Mutu)
            // ====================================================

            // Kita hanya cek data yang BARU SAJA masuk (dalam 1 menit terakhir)
            // Supaya notif tidak dikirim berulang-ulang untuk data lama yang sama
            if ($lastLog->created_at >= Carbon::now()->subMinute()) {

                $value = $lastLog->value;
                $threshold = $lastLog->parameter->max_threshold;
                $unit = $lastLog->parameter->unit;
                $paramName = $lastLog->parameter->name;
                $time = $lastLog->created_at->format('H:i:s d/m/Y');

                // Cek apakah melebihi batas?
                if ($value > $threshold) {

                    // Tentukan Level Bahaya
                    $statusType = 'ABNORMAL (BAKU MUTU)';
                    $headerEmoji = '🚨';

                    // Jika 2x lipat dari threshold -> Overrange
                    if ($value >= ($threshold * 2)) {
                        $statusType = 'OVERRANGE';
                        $headerEmoji = '⚛️';
                    }

                    // Format Pesan
                    $msg  = "<b>{$headerEmoji} EWS ALERT: {$statusType}</b>\n";
                    $msg .= "──────────────────────\n";
                    $msg .= "🏭 <b>" . ($stack->companyRelation->name ?? '-') . "</b>\n";
                    $msg .= "📍 <i>{$stack->stack_name} ({$stack->government_code})</i>\n\n";
                    $msg .= "📊 <b>Monitoring Data:</b>\n";
                    $msg .= "👉 <b>Parameter:</b> {$paramName}\n";
                    $msg .= "📈 <b>Value:</b> <code>{$value} {$unit}</code>\n";
                    $msg .= "⛔ <b>Baku Mutu:</b> {$threshold} {$unit}\n";
                    $msg .= "🕒 <b>Time:</b> {$time}\n";
                    $msg .= "──────────────────────\n";
                    $msg .= "🔗 <a href='" . url('/') . "'>Open Dashboard</a>";

                    $this->sendNotification($stack->company_id, $msg);
                }
            }
        }

        $this->info('Selesai.');
    }

    // Fungsi Kirim Dinamis (Sama seperti sebelumnya)
    private function sendNotification($companyId, $message)
    {
        $telegram = new TelegramService();

        // Cari Receiver aktif
        $receivers = ReceiverNotification::where('company_id', $companyId)
            ->where('is_active', true)
            ->whereHas('media', function($q) {
                $q->where('code', 'telegram');
            })
            ->get();

        if ($receivers->count() > 0) {
            foreach ($receivers as $receiver) {
                $telegram->sendMessage($message, $receiver->contact_value);
            }
        } else {
            // Backup ke default .env
            $telegram->sendMessage($message);
        }
    }
}