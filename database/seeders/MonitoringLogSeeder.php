<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MonitoringLog;
use App\Models\Stack;
use App\Models\Parameter;
use Carbon\Carbon;

class MonitoringLogSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua data Stack dan Parameter yang ada
        $stacks = Stack::all();
        $parameters = Parameter::all();

        if ($stacks->isEmpty() || $parameters->isEmpty()) {
            $this->command->info('Harap jalankan EwsSimulationSeeder atau isi data Stack & Parameter dulu!');
            return;
        }

        // Kita buat 500 data log simulasi
        for ($i = 0; $i < 500; $i++) {

            $randomStack = $stacks->random();
            $randomParam = $parameters->random();

            // Logika Nilai:
            // 80% kemungkinan data Normal (di bawah threshold)
            // 20% kemungkinan data Abnormal (di atas threshold)

            $threshold = $randomParam->max_threshold > 0 ? $randomParam->max_threshold : 100;
            $isAbnormal = rand(1, 100) <= 20; // 20% chance

            if ($isAbnormal) {
                // Generate nilai di atas batas (Misal batas 100, nilai jadi 101 - 150)
                $value = rand($threshold + 1, $threshold + 50);
            } else {
                // Generate nilai aman (Misal batas 100, nilai jadi 10 - 99)
                $value = rand(10, $threshold - 1);
            }

            // Logika Tanggal:
            // Acak tanggal dari 30 hari yang lalu sampai hari ini
            $date = Carbon::now()->subDays(rand(0, 30))->setTime(rand(0, 23), rand(0, 59));

            MonitoringLog::create([
                'stack_id' => $randomStack->id,
                'parameter_id' => $randomParam->id,
                'value' => $value,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}