<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;
use App\Models\DeviceStatusHistory;

class TestDeviceStatusSeeder extends Seeder
{
    public function run()
    {
        $device = Device::where('status', 'active')->first();

        if (!$device) {
            dd('Brak aktywnych urządzeń do testu!');
        }

        DeviceStatusHistory::where('device_id', $device->id)->delete();

        $threeDaysAgo = now()->subDays(3);
        $oneDayAgo    = now()->subDay();
        $MinAgo    = now()->subMinutes(61);

        DeviceStatusHistory::create([
            'device_id'   => $device->id,
            'from_status' => null,
            'to_status'   => 'aktywny',
            'reason'      => 'Status początkowy',
            'changed_at'  => $threeDaysAgo
        ]);

        DeviceStatusHistory::create([
            'device_id'   => $device->id,
            'from_status' => 'aktywny',
            'to_status'   => 'serwis',
            'reason'      => 'Przeniesiono do serwisu',
            'changed_at'  => $oneDayAgo
        ]);

        DeviceStatusHistory::create([
            'device_id'   => $device->id,
            'from_status' => 'serwis',
            'to_status'   => 'aktywny',
            'reason'      => 'Ponownie aktywowano',
            'changed_at'  => $MinAgo
        ]);

        $device->update([
            'status' => 'active',
            'status_updated_at' => $MinAgo
        ]);
    }
}
