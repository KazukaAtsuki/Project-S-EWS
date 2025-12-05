<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stack;
use App\Models\Parameter;
use App\Models\MonitoringLog;
use App\Models\NotificationSetting;
use App\Models\ReceiverNotification;
use App\Services\TelegramService;
use App\Mail\EwsAlertMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

// --- [IMPORT BARU UNTUK NOTIFIKASI] ---
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EwsAlertNotification;

class TelemetryController extends Controller
{
    public function receive(Request $request)
    {
        // 1. Validasi & Cari Data (Biarkan kode lama kamu di sini)
        $request->validate([
            'stack_code' => 'required',
            'parameter_code' => 'required',
            'value' => 'required|numeric',
        ]);

        $stack = Stack::where('government_code', $request->stack_code)->first();
        $parameter = Parameter::where('name', $request->parameter_code)->first();

        if (!$stack || !$parameter) {
            return response()->json(['status' => 'error'], 404);
        }

        MonitoringLog::create([
            'stack_id' => $stack->id,
            'parameter_id' => $parameter->id,
            'value' => $request->value
        ]);

        // 4. LOGIKA EWS (JIKA BAHAYA)
        if ($request->value > $parameter->max_threshold) {

            $statusType = 'ABNORMAL';
            if ($request->value >= ($parameter->max_threshold * 2)) {
                $statusType = 'OVERRANGE';
            }

            // ... (Kode Kirim Telegram Kamu di sini) ...
            // ... (Kode Kirim Email Kamu di sini) ...

            // ==========================================================
            // --- C. KIRIM NOTIFIKASI DATABASE (Tempel Disini) ---
            // ==========================================================

            // Siapkan data
            $notifData = [
                'status'     => $statusType,
                'stack_name' => $stack->stack_name,
                'parameter'  => $parameter->name,
                'value'      => $request->value,
                'unit'       => $parameter->unit,
            ];

            // Kirim ke SEMUA USER yang role-nya Admin & NOC
            $usersToNotify = User::whereIn('role', ['Admin', 'NOC'])->get();

            // Jalankan Notifikasi
            if($usersToNotify->count() > 0) {
                Notification::send($usersToNotify, new EwsAlertNotification($notifData));
            }

            // ==========================================================

            return response()->json(['status' => 'warning', 'message' => 'Alert Sent!']);
        }

        return response()->json(['status' => 'success']);
    }
}