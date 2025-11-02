<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class DeviceRepairController extends Controller
{
    public function index(Device $device)
    {
        $this->authorize('view', $device);

        $repairs = $device->repairs()->latest()->get();

        return view('devices.repairs.index', [
            'device' => $device,
            'repairs' => $repairs,
        ]);
    }
}
