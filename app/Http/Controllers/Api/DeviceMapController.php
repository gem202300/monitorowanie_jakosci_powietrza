<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DeviceMapController extends Controller
{
    public function index(Request $request)
    {
        $parameter = $request->get('parameter', 'temperature');
        $datetime = $request->get('datetime', now());
        $datetime = Carbon::parse($datetime);
        $oneHourAgo = $datetime->copy()->subHour();

        $devices = Device::whereHas('parameters', fn($q) =>
                $q->where('name', $parameter)
            )
            ->with(['parameters' => fn($q) => $q->where('name', $parameter)])
            ->get()
            ->map(function ($device) use ($parameter, $datetime, $oneHourAgo) {
                $measurement = $device->measurements()
                    ->whereBetween('date_time', [$oneHourAgo, $datetime])
                    ->orderByDesc('date_time')
                    ->first();

                if (!$measurement) return null;

                $value = DB::table('measurement_values')
                    ->where('measurement_id', $measurement->id)
                    ->join('parameters', 'measurement_values.parameter_id', '=', 'parameters.id')
                    ->where('parameters.name', $parameter)
                    ->value('value');

                return $value !== null ? [
                    'id' => $device->id,
                    'name' => $device->name,
                    'latitude' => $device->latitude,
                    'longitude' => $device->longitude,
                    'value' => $value,
                    'parameter' => $parameter,
                ] : null;
            })
            ->filter()
            ->values();

        return response()->json($devices);
    }
}
