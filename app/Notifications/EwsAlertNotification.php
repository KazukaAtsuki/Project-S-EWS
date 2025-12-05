<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EwsAlertNotification extends Notification
{
    use Queueable;

    public $data;

    // Terima data dari Controller
    public function __construct($data)
    {
        $this->data = $data;
    }

    // Tentukan channel pengiriman: DATABASE
    public function via($notifiable)
    {
        return ['database'];
    }

    // Format data yang akan disimpan ke database
    public function toArray($notifiable)
    {
        return [
            'title'   => '🚨 EWS ALERT: ' . $this->data['status'],
            'message' => "Stack {$this->data['stack_name']} - {$this->data['parameter']} ({$this->data['value']} {$this->data['unit']})",
            'link'    => route('monitoring.index'), // Link saat diklik
            'icon'    => 'bx-error',
            'color'   => 'danger', // Warna indikator (danger/warning/info)
            'time'    => now(),
        ];
    }
}