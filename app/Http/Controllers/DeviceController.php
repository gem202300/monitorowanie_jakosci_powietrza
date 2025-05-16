<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
   

public function index()
{
    $devices = Device::all();
    return view('devices.index', compact('devices'));
}

public function create()
{
    return view('devices.create');
}

public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|string',
        'address' => 'required|string',
        'longitude' => 'required|numeric',
        'latitude' => 'required|numeric',
    ]);

    Device::create($data);

    return redirect()->route('devices.index')->with('success', 'Device created successfully.');
}

public function edit(Device $device)
{
    return view('devices.edit', compact('device'));
}

public function update(Request $request, Device $device)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|string',
        'address' => 'required|string',
        'longitude' => 'required|numeric',
        'latitude' => 'required|numeric',
    ]);

    $device->update($data);

    return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
}

public function destroy(Device $device)
{
    $device->delete();

    return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
}

public function showMeasurements(Device $device)
    {
        // Eager load relationships
        $device->load([
            'parameters',
            'measurements' => function($query) {
                $query->latest()->take(100); // Limit to 100 most recent measurements
            },
            'measurements.values',
            'measurements.values.parameter'
        ]);
        
        return view('devices.measurements', compact('device'));
    }

}
