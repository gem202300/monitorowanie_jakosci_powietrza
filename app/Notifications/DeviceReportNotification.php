<?php

namespace App\Notifications;

use App\Models\DeviceReport;
use Illuminate\Notifications\Notification;

class DeviceReportNotification extends Notification
{
    public DeviceReport $deviceReport;

    public function __construct(DeviceReport $deviceReport)
    {
        $this->deviceReport = $deviceReport;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => "Nowe zgłoszenie dla urządzenia: {$this->deviceReport->device->name}",
            'body' => "Raport z problemu: {$this->deviceReport->reason}",
            'device_report_id' => $this->deviceReport->id,
            'device_id' => $this->deviceReport->device_id,
            'reporter_name' => $this->deviceReport->user->name,
            'reporter_email' => $this->deviceReport->user->email,
            'description' => $this->deviceReport->description,
        ];
    }
}
