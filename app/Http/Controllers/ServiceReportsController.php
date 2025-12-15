<?php

namespace App\Http\Controllers;

use App\Models\DeviceReport;
use App\Models\DeviceRepair;
use App\Models\Device;
use App\Models\DeviceStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServiceReportsController extends Controller
{
    /**
     * Display service reports for the authenticated serviceman
     */
    public function index()
    {
        // Ensure user is a serviceman
        if (!Auth::user()->isServiceman()) {
            abort(403, 'Unauthorized');
        }

        return view('service-reports.index');
    }

    /**
     * Show all reports for a specific device with details and notes form
     */
    public function show(Device $device)
    {
        // Ensure user is a serviceman
        if (!Auth::user()->isServiceman()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();

        // Check if serviceman is assigned to this device
        $isAssigned = $device->users()
            ->where('users.id', $user->id)
            ->wherePivot('assign_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('user_devices.unassign_at')
                      ->orWhere('user_devices.unassign_at', '>', now());
            })
            ->exists();

        if (!$isAssigned) {
            abort(403, 'Nie jesteś przypisany do tego urządzenia');
        }

        // Get all reports for this device
        $reports = $device->reports()
            ->orderBy('created_at', 'asc')
            ->get();

        // Only show if device has 4 or more reports
        if ($reports->count() < 4) {
            return redirect()->route('service-reports.index')
                ->with('error', 'To urządzenie nie ma wystarczającej liczby zgłoszeń');
        }

        return view('service-reports.show', [
            'reports' => $reports,
            'device' => $device,
        ]);
    }

    /**
     * Resolve all service reports for a device and create a repair record
     */
    public function resolve(Request $request, Device $device)
    {
        // Ensure user is a serviceman
        if (!Auth::user()->isServiceman()) {
            abort(403, 'Unauthorized');
        }

        // Validate notes input
        $request->validate([
            'notes' => 'required|string|min:10',
        ]);

        $user = Auth::user();

        // Check if serviceman is assigned to this device
        $isAssigned = $device->users()
            ->where('users.id', $user->id)
            ->wherePivot('assign_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('user_devices.unassign_at')
                      ->orWhere('user_devices.unassign_at', '>', now());
            })
            ->exists();

        if (!$isAssigned) {
            return back()->with('error', 'Nie jesteś przypisany do tego urządzenia');
        }

        // Get all reports for this device
        $reports = $device->reports()->get();

        if ($reports->isEmpty()) {
            return back()->with('error', 'Brak zgłoszeń dla tego urządzenia');
        }

        try {
            // Build comprehensive description from all reports
            $repairDescription = "Rozwiązano zgłoszenia serwisowe dla urządzenia: {$device->name}\n\n";
            $repairDescription .= "Liczba zgłoszeń: {$reports->count()}\n\n";
            
            $repairDescription .= "Szczegóły zgłoszeń:\n";
            foreach ($reports as $index => $report) {
                $repairDescription .= "\n" . ($index + 1) . ". ";
                $repairDescription .= "Powód: " . $report->reason;
                if ($report->description) {
                    $repairDescription .= "\n   Opis: " . $report->description;
                }
                $repairDescription .= "\n   Data: " . $report->created_at->format('Y-m-d H:i');
                $repairDescription .= "\n   Zgłosił: " . $report->user->name;
            }
            
            // Add serviceman's notes
            $repairDescription .= "\n\n=== NOTATKI SERWISANTA ===\n";
            $repairDescription .= $request->input('notes');

            // Store first report date
            $firstReportDate = $reports->min('created_at');
            
            // Store report IDs for reference
            $reportIds = $reports->pluck('id')->toArray();

            // Delete all device reports for this device
            DeviceReport::where('device_id', $device->id)->delete();

            // Create a single repair record for all resolved reports
            $repair = DeviceRepair::create([
                'device_id' => $device->id,
                'device_report_id' => $reportIds[0], // Reference first report ID
                'user_id' => $user->id,
                'type' => 'repair',
                'description' => $repairDescription,
                'reported_at' => $firstReportDate,
                'resolved_at' => now(),
            ]);

            // Check if device should be reactivated
            // Count remaining reports after this status update
            $remainingReportsCount = DeviceReport::where('device_id', $device->id)
                ->when($device->status_updated_at, function ($query, $status_updated_at) {
                    $query->where('created_at', '>=', $status_updated_at);
                })
                ->count();

            // If device is inactive and there are less than 4 reports, reactivate it
            if ($device->status === 'inactive' && $remainingReportsCount < 4) {
                $oldStatus = $device->status;
                $device->status = 'active';
                $device->status_updated_at = now();
                $device->save();

                $reason = "Automatyczna zmiana statusu: rozwiązano zgłoszenie, pozostało {$remainingReportsCount} zgłoszeń. Naprawa ID: {$repair->id}.";

                // Create status history entry
                DeviceStatusHistory::create([
                    'device_id' => $device->id,
                    'from_status' => $oldStatus,
                    'to_status' => $device->status,
                    'reason' => $reason,
                    'changed_at' => now(),
                ]);
            }

            return redirect()
                ->route('service-reports.index')
                ->with('success', __('service_reports.resolve_success'));
        } catch (\Exception $e) {
            Log::error('Error resolving service report: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return back()
                ->with('error', __('service_reports.resolve_error'))
                ->withInput();
        }
    }
}

