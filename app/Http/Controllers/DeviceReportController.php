<?php
namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceReport;
use App\Notifications\DeviceReportNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeviceReportController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $device = Device::findOrFail($request->device_id);

        $deviceReport = DeviceReport::create([
            'device_id' => $device->id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        // Рахуємо лише звіти після останньої зміни статусу
        $openReportsCount = DeviceReport::where('device_id', $device->id)
            ->when($device->status_updated_at, function ($query, $status_updated_at) {
                $query->where('created_at', '>=', $status_updated_at);
            })
            ->count();

        if ($openReportsCount >= 4 && $device->status === 'active') {
            $device->status = 'inactive';
            $device->status_updated_at = now();
            $device->save();
        }

        // Find servicemen assigned to this device and send them email notifications
        $this->notifyServicemen($device, $deviceReport);

        return response()->json(['message' => 'Zgłoszenie zostało zapisane']);
    }

    /**
     * Find servicemen assigned to device and send them notification
     */
    private function notifyServicemen(Device $device, DeviceReport $deviceReport): void
    {
        try {
            Log::info("Starting notification process for device: {$device->id}");

            // Get active servicemen assigned to the device
            // Filter by active assignments (assign_at <= now and unassign_at is null or > now)
            $servicemen = $device->users()
                ->whereHas('roles', function ($q) {
                    $q->where('name', 'serwisant');
                })
                ->wherePivot('assign_at', '<=', now())
                ->where(function ($query) {
                    $query->whereNull('user_devices.unassign_at')
                          ->orWhere('user_devices.unassign_at', '>', now());
                })
                ->get();

            Log::info("Found " . $servicemen->count() . " servicemen for device {$device->id}");
            Log::info("Servicemen details: " . json_encode($servicemen->map(function ($s) {
                return ['id' => $s->id, 'email' => $s->email, 'name' => $s->name];
            })->toArray()));

            // Send notification to each serviceman
            foreach ($servicemen as $serviceman) {
                try {
                    Log::info("Sending notification to serviceman: {$serviceman->email}");
                    $serviceman->notify(new DeviceReportNotification($deviceReport));
                    Log::info("Successfully notified serviceman: {$serviceman->email}");
                } catch (\Exception $e) {
                    Log::error("Failed to notify serviceman {$serviceman->email}: " . $e->getMessage());
                    Log::error("Stack trace: " . $e->getTraceAsString());
                }
            }
        } catch (\Exception $e) {
            Log::error("Error notifying servicemen about device report: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            // Don't throw - we still want the report to be saved even if notification fails
        }
    }
}