<?php

namespace App\Http\Livewire\Devices;

use Livewire\Component;
use App\Models\Device;

class DeviceTable extends Component
{
    public $devices;

    public function mount()
    {
        $this->devices = Device::all();
    }

    public function render()
    {
        return view('livewire.devices.device-table');
    }
}

