<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $botToken;
    protected string $apiUrl;
    protected ?string $defaultChatId;

    public function __construct()
    {
        $this->botToken = config('telegram.bot_token');
        $this->apiUrl = config('telegram.api_url');
        $this->defaultChatId = config('telegram.chat_id');
    }

    /**
     * Send a message to Telegram
     *
     * @param string $message The message to send
     * @param string|null $chatId Optional chat ID (uses default if not provided)
     * @param string $parseMode Optional parse mode (Markdown, HTML)
     * @return array Response from Telegram API
     */
    public function sendMessage(string $message, ?string $chatId = null, string $parseMode = 'HTML'): array
    {
        $chatId = $chatId ?? $this->defaultChatId;

        if (empty($this->botToken)) {
            Log::error('Telegram bot token is not configured');
            return [
                'ok' => false,
                'error' => 'Bot token not configured'
            ];
        }

        if (empty($chatId)) {
            Log::error('Telegram chat ID is not configured');
            return [
                'ok' => false,
                'error' => 'Chat ID not configured'
            ];
        }

        try {
            $url = $this->apiUrl . $this->botToken . '/sendMessage';

            $response = Http::post($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => $parseMode,
            ]);

            $result = $response->json();

            if (!$response->successful() || !($result['ok'] ?? false)) {
                Log::error('Failed to send Telegram message', [
                    'response' => $result,
                    'status' => $response->status()
                ]);
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Exception while sending Telegram message: ' . $e->getMessage());
            return [
                'ok' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send alert notification to Telegram
     *
     * @param string $title Alert title
     * @param string $message Alert message
     * @param string $level Alert level (warning, danger, info)
     * @param array $additionalData Additional data to include
     * @param string|null $chatId Optional chat ID
     * @return array Response from Telegram API
     */
    public function sendAlert(
        string $title,
        string $message,
        string $level = 'warning',
        array $additionalData = [],
        ?string $chatId = null
    ): array {
        $emoji = match($level) {
            'danger', 'critical' => '🚨',
            'warning' => '⚠️',
            'info' => 'ℹ️',
            'success' => '✅',
            default => '📢'
        };

        $formattedMessage = "<b>{$emoji} {$title}</b>\n\n";
        $formattedMessage .= "{$message}\n";

        if (!empty($additionalData)) {
            $formattedMessage .= "\n<b>Detail:</b>\n";
            foreach ($additionalData as $key => $value) {
                $formattedMessage .= "• <b>{$key}:</b> {$value}\n";
            }
        }

        $formattedMessage .= "\n<i>Time: " . now()->format('Y-m-d H:i:s') . "</i>";

        return $this->sendMessage($formattedMessage, $chatId);
    }

    /**
     * Send notification to multiple chat IDs
     *
     * @param string $message The message to send
     * @param array $chatIds Array of chat IDs
     * @return array Array of responses
     */
    public function sendToMultiple(string $message, array $chatIds): array
    {
        $results = [];

        foreach ($chatIds as $chatId) {
            $results[$chatId] = $this->sendMessage($message, $chatId);
        }

        return $results;
    }

    /**
     * Get bot information
     *
     * @return array Bot information
     */
    public function getBotInfo(): array
    {
        try {
            $url = $this->apiUrl . $this->botToken . '/getMe';
            $response = Http::get($url);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Exception while getting bot info: ' . $e->getMessage());
            return [
                'ok' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
