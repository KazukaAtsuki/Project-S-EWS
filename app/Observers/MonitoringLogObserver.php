<?php

namespace App\Observers;

use App\Models\MonitoringLog;
use App\Models\ReceiverNotification;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;

class MonitoringLogObserver
{
    protected TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Handle the MonitoringLog "created" event.
     * Check if parameter value exceeds threshold and send alert
     */
    public function created(MonitoringLog $monitoringLog): void
    {
        // Load relasi yang diperlukan
        $monitoringLog->load(['parameter', 'stack.company']);

        $parameter = $monitoringLog->parameter;
        $value = $monitoringLog->value;
        $threshold = $parameter->max_threshold;

        // Check jika value melebihi threshold
        if ($value > $threshold) {
            $this->sendThresholdAlert($monitoringLog);
        }
    }

    /**
     * Send alert when threshold is exceeded
     *
     * @param MonitoringLog $monitoringLog
     * @return void
     */
    protected function sendThresholdAlert(MonitoringLog $monitoringLog): void
    {
        $parameter = $monitoringLog->parameter;
        $stack = $monitoringLog->stack;
        $company = $stack->company ?? null;
        $value = $monitoringLog->value;
        $threshold = $parameter->max_threshold;
        $exceededBy = round($value - $threshold, 2);
        $exceededPercent = round((($value - $threshold) / $threshold) * 100, 2);

        // Determine alert level based on how much threshold is exceeded
        $level = 'warning';
        if ($exceededPercent > 50) {
            $level = 'critical';
        } elseif ($exceededPercent > 25) {
            $level = 'danger';
        }

        // Prepare alert data
        $additionalData = [
            'Parameter' => $parameter->name,
            'Current Value' => $value . ' ' . ($parameter->unit ?? ''),
            'Threshold' => $threshold . ' ' . ($parameter->unit ?? ''),
            'Exceeded By' => $exceededBy . ' ' . ($parameter->unit ?? ''),
            'Exceeded %' => $exceededPercent . '%',
            'Stack' => $stack->name ?? 'N/A',
        ];

        if ($company) {
            $additionalData['Company'] = $company->name;
        }

        // Get receivers for this company (Telegram only)
        $receivers = $this->getTelegramReceivers($company->id ?? null);

        if ($receivers->isEmpty()) {
            // Use default chat_id from config if no specific receivers
            $this->sendAlertToDefault($parameter->name, $level, $additionalData);
        } else {
            // Send to all registered Telegram receivers for this company
            foreach ($receivers as $receiver) {
                if ($receiver->is_active && !empty($receiver->contact_value)) {
                    $this->telegram->sendAlert(
                        "🚨 EWS Alert: {$parameter->name} Threshold Exceeded",
                        "Parameter {$parameter->name} has exceeded the safe threshold at {$stack->name}.",
                        $level,
                        $additionalData,
                        $receiver->contact_value // Telegram Chat ID
                    );
                }
            }
        }

        // Log the alert
        Log::warning('Threshold exceeded alert sent', [
            'parameter' => $parameter->name,
            'value' => $value,
            'threshold' => $threshold,
            'stack' => $stack->name ?? 'N/A',
            'company' => $company->name ?? 'N/A',
        ]);
    }

    /**
     * Send alert to default chat_id from config
     *
     * @param string $parameterName
     * @param string $level
     * @param array $additionalData
     * @return void
     */
    protected function sendAlertToDefault(string $parameterName, string $level, array $additionalData): void
    {
        $this->telegram->sendAlert(
            "🚨 EWS Alert: {$parameterName} Threshold Exceeded",
            "Parameter {$parameterName} has exceeded the safe threshold.",
            $level,
            $additionalData
        );
    }

    /**
     * Get Telegram receivers for specific company
     *
     * @param int|null $companyId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getTelegramReceivers(?int $companyId)
    {
        if (!$companyId) {
            return collect([]);
        }

        return ReceiverNotification::where('company_id', $companyId)
            ->where('is_active', true)
            ->whereHas('media', function ($query) {
                $query->where('code', 'telegram');
            })
            ->with('media')
            ->get();
    }

    /**
     * Handle the MonitoringLog "updated" event.
     */
    public function updated(MonitoringLog $monitoringLog): void
    {
        //
    }

    /**
     * Handle the MonitoringLog "deleted" event.
     */
    public function deleted(MonitoringLog $monitoringLog): void
    {
        //
    }

    /**
     * Handle the MonitoringLog "restored" event.
     */
    public function restored(MonitoringLog $monitoringLog): void
    {
        //
    }

    /**
     * Handle the MonitoringLog "force deleted" event.
     */
    public function forceDeleted(MonitoringLog $monitoringLog): void
    {
        //
    }
}

