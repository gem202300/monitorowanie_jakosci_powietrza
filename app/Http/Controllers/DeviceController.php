<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
   

public function index()
{
    $devices = Device::all(); // отримаємо всі записи
    return view('devices.index', compact('devices'));
}

}
