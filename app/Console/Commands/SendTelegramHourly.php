<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;

class SendTelegramHourly extends Command
{
    /**
     * The name and signature of the console command.
     * Ini adalah perintah yang nanti diketik di terminal
     *
     * @var string
     */
    protected $signature = 'telegram:send-hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim notifikasi rutin atau monitoring ke Telegram';

    protected TelegramService $telegram;

    /**
     * Create a new command instance.
     */
    public function __construct(TelegramService $telegram)
    {
        parent::__construct();
        $this->telegram = $telegram;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses pengiriman notifikasi Telegram...');

        try {
            // --- CONTOH 1: Kirim Status Rutin (Heartbeat) ---
            $this->telegram->sendAlert(
                'Status Monitoring Rutin',
                'Sistem EWS berjalan dengan normal.',
                'info',
                [
                    'Server Time' => now()->format('Y-m-d H:i:s'),
                    'Status' => 'Running',
                    'Check Interval' => '1 Hour'
                ]
            );

            // --- CONTOH 2: Simulasi Pengecekan Data (Seperti testParameterDrop di Controller) ---
            // Disini kamu bisa query ke database kamu.
            // Contoh Logic:
            // $latestData = SensorData::latest()->first();
            // if ($latestData->value > $threshold) { ... }

            // Simulasi data dummy untuk contoh:
            $currentValue = rand(10, 100);
            $threshold = 80;

            if ($currentValue > $threshold) {
                $this->telegram->sendAlert(
                    '⚠️ Peringatan Ambang Batas!',
                    "Parameter simulasi melebihi batas aman saat pengecekan rutin.",
                    'warning',
                    [
                        'Parameter' => 'Simulasi Oksigen',
                        'Nilai Saat Ini' => $currentValue,
                        'Ambang Batas' => $threshold
                    ]
                );
                $this->error("Alert terkirim: Nilai $currentValue melebihi $threshold");
            } else {
                $this->info("Kondisi aman: Nilai $currentValue");
            }

            $this->info('Notifikasi berhasil dikirim.');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Gagal mengirim notifikasi: ' . $e->getMessage());
            Log::error('Scheduler Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}