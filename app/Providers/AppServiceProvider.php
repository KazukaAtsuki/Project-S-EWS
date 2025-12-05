<?php

namespace App\Providers;

use App\Models\MonitoringLog;
use App\Observers\MonitoringLogObserver;
use Illuminate\Support\ServiceProvider;
// --- Tambahan Import untuk Widget Status ---
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Register MonitoringLog Observer (Kode Lama Anda Tetap Ada)
        MonitoringLog::observe(MonitoringLogObserver::class);

        // 2. Logika SYSTEM STATUS WIDGET (Untuk Navbar)
        // Kode ini akan berjalan otomatis setiap kali layout admin dimuat
        View::composer('layouts.admin', function ($view) {

            // A. Set Default Status (Anggap Aman Dulu)
            $sysStatus = 'OPTIMAL';
            $sysColor = 'success';  // Hijau
            $sysPulse = 'bg-success';

            // B. Ambil Log Data 30 Menit Terakhir
            // Kita perlu relasi 'parameter' untuk tahu batas ambang bahaya (max_threshold)
            $lastLogs = MonitoringLog::with('parameter')
                ->where('created_at', '>=', Carbon::now()->subMinutes(30))
                ->get();

            // C. Cek Kondisi
            if ($lastLogs->isEmpty()) {
                // KONDISI 1: Tidak ada data masuk > 30 menit (Offline)
                $sysStatus = 'NO DATA';
                $sysColor = 'warning'; // Kuning
                $sysPulse = 'bg-warning';
            } else {
                // KONDISI 2: Ada data, cek apakah ada yang Abnormal?
                foreach ($lastLogs as $log) {
                    // Pastikan parameter ada, lalu cek nilainya
                    if ($log->parameter && $log->value > $log->parameter->max_threshold) {
                        $sysStatus = 'WARNING';
                        $sysColor = 'danger'; // Merah
                        $sysPulse = 'bg-danger';
                        break; // Ketemu satu saja yang bahaya, status sistem langsung merah
                    }
                }
            }

            // D. Kirim Variabel ke View (Navbar)
            $view->with([
                'sysStatus' => $sysStatus,
                'sysColor' => $sysColor,
                'sysPulse' => $sysPulse
            ]);
        });
    }
}