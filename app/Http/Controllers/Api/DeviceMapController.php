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
    $datetime = $request->get('datetime'); // може бути null

    if ($datetime) {
        $datetime = Carbon::parse($datetime);
        $oneHourAgo = $datetime->copy()->subHour();
    }

    $devices = Device::with(['parameters' => fn($q) => 
        $q->where('name', $parameter)
    ])->get();

    $result = [];

    foreach ($devices as $device) {

        // 1. Беремо вимірювання
        $measurementQuery = $device->measurements()
            ->orderByDesc('date_time');

        if ($datetime) {
            $measurementQuery->whereBetween('date_time', [$oneHourAgo, $datetime]);
        }

        $measurement = $measurementQuery->first();

        if (!$measurement) continue;

        // 2. Знаходимо статус пристрою у момент вимірювання
        $status = DB::table('device_status_histories')
            ->where('device_id', $device->id)
            ->where('changed_at', '<=', $measurement->date_time)
            ->orderByDesc('changed_at')
            ->value('to_status');

        if ($status !== 'aktywny') {
            continue; // ❗ пропускаємо якщо не active
        }

        // 3. Отримуємо значення параметра
        $value = DB::table('measurement_values')
            ->where('measurement_id', $measurement->id)
            ->join('parameters', 'measurement_values.parameter_id', '=', 'parameters.id')
            ->where('parameters.name', $parameter)
            ->value('value');

        if ($value === null) continue;

        $result[] = [
            'id' => $device->id,
            'name' => $device->name,
            'latitude' => $device->latitude,
            'longitude' => $device->longitude,
            'value' => $value,
            'parameter' => $parameter,
            'timestamp' => $measurement->date_time,
        ];
    }

    return response()->json($result);
}


}
