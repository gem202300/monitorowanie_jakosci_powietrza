<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Device;

class DeviceStatusChangedNotification extends Notification
{
    public Device $device;
    public ?string $from;
    public string $to;
    public ?string $reason;
    public $changedAt;

    public function __construct(Device $device, ?string $from, string $to, ?string $reason = null, $changedAt = null)
    {
        $this->device = $device;
        $this->from = $from;
        $this->to = $to;
        $this->reason = $reason;
        $this->changedAt = $changedAt ?? now();
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => "Urządzenie {$this->device->name} zmieniło status",
            'body' => "Status zmieniony z: {$this->from} na: {$this->to}",
            'device_id' => $this->device->id,
            'from_status' => $this->from,
            'to_status' => $this->to,
            'reason' => $this->reason,
            'changed_at' => $this->changedAt,
            'type' => 'critical',
        ];
    }
}