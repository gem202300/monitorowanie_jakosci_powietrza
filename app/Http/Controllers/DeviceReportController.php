<?php
namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceReport;
use App\Notifications\DeviceReportNotification;
use App\Notifications\DeviceStatusChangedNotification;
use App\Models\DeviceStatusHistory;
use App\Models\User;
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
            'type' => 'nullable|string|in:info,warning,critical,incident',
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
            // Save old status, change device status and record history via helper
            $oldStatus = $device->status;
            $device->status = 'inactive';
            $device->status_updated_at = now();
            $device->save();

            $reason = "Automatyczna zmiana statusu: wykryto {$openReportsCount} otwartych zgłoszeń. Raport ID: {$deviceReport->id}.";

            // create history entry using reusable helper
            $this->createStatusHistory($device, $oldStatus, $device->status, $reason);

            // notify all admins that device became inactive
            try {
                $this->notifyAdminsOnInactive($device, $oldStatus, $device->status, $reason);
            } catch (\Exception $e) {
                Log::error('Failed to notify admins on device inactive: ' . $e->getMessage());
            }
        }

        // Find servicemen assigned to this device and send them notifications
        $type = $request->input('type', 'warning');
        $this->notifyServicemen($device, $deviceReport, $type);

        return response()->json(['message' => 'Zgłoszenie zostało zapisane']);
    }

    /**
     * Find servicemen assigned to device and send them notification
     */
    private function notifyServicemen(Device $device, DeviceReport $deviceReport, string $type = 'info'): void
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
                    $serviceman->notify(new DeviceReportNotification($deviceReport, $type));
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

    private function createStatusHistory(Device $device, ?string $from, string $to, ?string $reason = null, $changedAt = null)
    {
        try {
            $data = [
                'from_status' => $from,
                'to_status' => $to,
                'reason' => $reason,
                'changed_at' => $changedAt ?? now(),
            ];

            if (method_exists($device, 'statusHistories')) {
                return $device->statusHistories()->create($data);
            }

            return DeviceStatusHistory::create(array_merge($data, ['device_id' => $device->id]));
        } catch (\Exception $e) {
            Log::error('Failed to create device status history: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return null;
        }
    }

    /**
     * Notify all admins with a database notification when device becomes inactive
     */
    private function notifyAdminsOnInactive(Device $device, ?string $from, string $to, ?string $reason = null): void
    {
        if ($to !== 'inactive') {
            return; // only notify on inactive
        }

        try {
            $admins = User::whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            })->get();

            foreach ($admins as $admin) {
                try {
                    $admin->notify(new DeviceStatusChangedNotification($device, $from, $to, $reason));
                } catch (\Exception $e) {
                    Log::error("Failed to notify admin {$admin->email}: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            Log::error('Error while notifying admins: ' . $e->getMessage());
        }
    }
        public function index()
    {
        return view('device-reports.index');
    }

}