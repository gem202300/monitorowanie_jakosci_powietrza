<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeviceController extends Controller
{
    use App\Models\Device;

public function index()
{
    $devices = Device::all(); // отримаємо всі записи
    return view('devices.index', compact('devices'));
}

}
