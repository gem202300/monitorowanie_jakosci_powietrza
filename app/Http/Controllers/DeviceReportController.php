<?php
namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        DeviceReport::create([
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

        return response()->json(['message' => 'Zgłoszenie zostało zapisane']);
    }
}
