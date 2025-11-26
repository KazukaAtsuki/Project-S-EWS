<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stack;
use App\Models\Parameter;
use App\Models\MonitoringLog;
use App\Models\NotificationSetting;
use App\Models\ReceiverNotification;
use App\Services\TelegramService; // Pastikan ini terimport
use App\Mail\EwsAlertMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TelemetryController extends Controller
{
    public function receive(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'stack_code' => 'required|string',
            'parameter_code' => 'required|string',
            'value' => 'required|numeric',
        ]);

        // 2. CARI DATA MASTER
        $stack = Stack::where('government_code', $request->stack_code)->first();
        $parameter = Parameter::where('name', $request->parameter_code)->first();

        if (!$stack || !$parameter) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data Stack atau Parameter tidak ditemukan di Database.'
            ], 404);
        }

        // 3. SIMPAN LOG
        MonitoringLog::create([
            'stack_id' => $stack->id,
            'parameter_id' => $parameter->id,
            'value' => $request->value
        ]);

        // 4. LOGIKA EWS
        if ($request->value > $parameter->max_threshold) {

            $setting = NotificationSetting::where('event_name', 'ews_alert_triggered')->first();

            if (!$setting) {
                return response()->json(['status' => 'warning', 'message' => 'Threshold exceeded, but notification setting not found.']);
            }

            $time = Carbon::now()->format('d M Y H:i:s');
            $companyId = $stack->company_id;

            // --- A. KIRIM TELEGRAM ---
            if ($setting->telegram_enabled) {

                // [FIX] Inisialisasi Service
                $telegram = new TelegramService();

                $teleReceivers = ReceiverNotification::where('company_id', $companyId)
                    ->where('is_active', true)
                    ->whereHas('media', function($q) {
                        $q->where('code', 'telegram');
                    })
                    ->get();

                $msg = "🚨 <b>EWS ALERT WARNING!</b> 🚨\n\n";
                $msg .= "<b>Company:</b> " . ($stack->companyRelation->name ?? '-') . "\n";
                $msg .= "<b>Lokasi:</b> {$stack->stack_name} ({$stack->government_code})\n";
                $msg .= "<b>Parameter:</b> {$parameter->name}\n";
                $msg .= "<b>Nilai Terbaca:</b> {$request->value} {$parameter->unit}\n";
                $msg .= "<b>Batas Aman:</b> {$parameter->max_threshold} {$parameter->unit}\n";
                $msg .= "<b>Waktu:</b> {$time}\n\n";
                $msg .= "⚠️ <i>Mohon segera dilakukan pengecekan di lapangan!</i>";

                // [FIX] Gunakan method sendMessage() bukan send()
                if ($teleReceivers->count() > 0) {
                    foreach ($teleReceivers as $receiver) {
                        // Panggil lewat variable $telegram->
                        $telegram->sendMessage($msg, $receiver->contact_value);
                    }
                } else {
                    // Backup default
                    $telegram->sendMessage($msg);
                }
            }

            // --- B. KIRIM EMAIL ---
            if ($setting->email_enabled) {
                $emailReceivers = ReceiverNotification::where('company_id', $companyId)
                    ->where('is_active', true)
                    ->whereHas('media', function($q) {
                        $q->where('code', 'email');
                    })
                    ->get();

                $emailData = [
                    'company_name' => $stack->companyRelation->name ?? '-',
                    'stack_name' => $stack->stack_name,
                    'stack_code' => $stack->government_code,
                    'parameter_name' => $parameter->name,
                    'value' => $request->value,
                    'threshold' => $parameter->max_threshold,
                    'unit' => $parameter->unit,
                    'time' => $time,
                ];

                foreach ($emailReceivers as $receiver) {
                    try {
                        Mail::to($receiver->contact_value)->send(new EwsAlertMail($emailData));
                    } catch (\Exception $e) {
                        Log::error('Gagal kirim email EWS: ' . $e->getMessage());
                    }
                }
            }

            return response()->json([
                'status' => 'warning',
                'message' => 'THRESHOLD EXCEEDED! Alerts sent via enabled channels.',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data received & saved. Status Normal.',
        ]);
    }
}