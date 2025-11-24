<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TelegramController extends Controller
{
    protected TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Test endpoint to send a simple message
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:4096',
            'chat_id' => 'nullable|string',
        ]);

        $response = $this->telegram->sendMessage(
            $validated['message'],
            $validated['chat_id'] ?? null
        );

        return response()->json($response);
    }

    /**
     * Test endpoint to send an alert
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendAlert(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:4096',
            'level' => 'nullable|string|in:info,warning,danger,critical,success',
            'additional_data' => 'nullable|array',
            'chat_id' => 'nullable|string',
        ]);

        $response = $this->telegram->sendAlert(
            $validated['title'],
            $validated['message'],
            $validated['level'] ?? 'warning',
            $validated['additional_data'] ?? [],
            $validated['chat_id'] ?? null
        );

        return response()->json($response);
    }

    /**
     * Get bot information
     *
     * @return JsonResponse
     */
    public function getBotInfo(): JsonResponse
    {
        $response = $this->telegram->getBotInfo();
        return response()->json($response);
    }

    /**
     * Test parameter drop simulation
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function testParameterDrop(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'parameter_name' => 'required|string',
            'current_value' => 'required|numeric',
            'threshold' => 'required|numeric',
            'company_name' => 'nullable|string',
            'stack_name' => 'nullable|string',
        ]);

        $currentValue = $validated['current_value'];
        $threshold = $validated['threshold'];
        $parameterName = $validated['parameter_name'];

        // Check if value exceeds threshold
        if ($currentValue > $threshold) {
            $response = $this->telegram->sendAlert(
                'Parameter Threshold Exceeded!',
                "Parameter {$parameterName} has exceeded the safe threshold.",
                'danger',
                [
                    'Parameter' => $parameterName,
                    'Current Value' => $currentValue,
                    'Threshold' => $threshold,
                    'Exceeded By' => round($currentValue - $threshold, 2),
                    'Company' => $validated['company_name'] ?? 'N/A',
                    'Stack' => $validated['stack_name'] ?? 'N/A',
                ]
            );

            return response()->json([
                'alert_triggered' => true,
                'telegram_response' => $response
            ]);
        }

        return response()->json([
            'alert_triggered' => false,
            'message' => 'Parameter is within safe limits'
        ]);
    }

    // public function webhook(Request $request)
    // {
    //     $data = $request->all();
    //     if (isset($data['message']['text']) && $data['message']['text'] === '/start') {
    //         $chatId = $data['message']['chat']['id'];
    //         // Simpan chatId ke database jika belum ada
    //         // Contoh: ReceiverNotification::firstOrCreate(['chat_id' => $chatId]);
    //     }
    //     return response()->json(['ok' => true]);
    // }
}
