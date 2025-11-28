<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stack;
use App\Models\Parameter;
use App\Models\MonitoringLog;

class TelemetryController extends Controller
{
    /**
     * Endpoint untuk menerima data sensor (POST)
     *
     * Note: Logika Notifikasi (Alert Abnormal/Overrange) sudah dipindahkan
     * ke Scheduler (CheckDeviceActivity) agar API ini berjalan ringan (Lightweight).
     */
    public function receive(Request $request)
    {
        // 1. VALIDASI INPUT
        // Memastikan sensor mengirim format yang benar
        $request->validate([
            'stack_code'     => 'required|string', // Contoh: ST-01
            'parameter_code' => 'required|string', // Contoh: CO
            'value'          => 'required|numeric', // Contoh: 150
        ]);

        // 2. CARI DATA MASTER
        // Kita perlu ID dari Stack dan Parameter untuk disimpan di log
        $stack = Stack::where('government_code', $request->stack_code)->first();
        $parameter = Parameter::where('name', $request->parameter_code)->first();

        // Jika Stack atau Parameter tidak dikenali di database, tolak request
        if (!$stack || !$parameter) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Stack atau Parameter tidak ditemukan di Database Master.'
            ], 404);
        }

        // 3. SIMPAN LOG MONITORING
        // Simpan data ke database. Nanti Robot Scheduler yang akan mengecek data ini tiap menit.
        $log = MonitoringLog::create([
            'stack_id'     => $stack->id,
            'parameter_id' => $parameter->id,
            'value'        => $request->value
        ]);

        // 4. RESPONSE SUKSES
        // Berikan info balik ke sensor/client bahwa data aman tersimpan
        return response()->json([
            'status' => 'success',
            'message' => 'Data received & saved. Analysis will be done by Scheduler.',
            'data' => [
                'log_id' => $log->id,
                'timestamp' => $log->created_at->format('Y-m-d H:i:s'),
                'value_recorded' => $log->value
            ]
        ], 201); // Kode 201 artinya Created (Berhasil dibuat)
    }
}