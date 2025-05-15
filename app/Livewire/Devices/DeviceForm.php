<?php
namespace App\Http\Livewire\Devices;

use Livewire\Component;
use App\Models\Device;

class DeviceForm extends Component
{
    public ?Device $device;

    public $name;
    public $status = 'active';
    public $address;
    public $longitude;
    public $latitude;

    protected $rules = [
        'name' => 'required|string|max:255',
        'status' => 'required|in:active,maintenance,inactive',
        'address' => 'required|string|max:255',
        'longitude' => 'required|numeric',
        'latitude' => 'required|numeric',
    ];

    public function mount($device = null)
{
    if ($device) {
        $this->device = Device::findOrFail($device);
        $this->fill($this->device->only(['name', 'status', 'address', 'longitude', 'latitude']));
    } else {
        $this->device = new Device();
    }
}


    public function submit()
    {
        $this->validate();

        $data = $this->only(['name', 'status', 'address', 'longitude', 'latitude']);

        $this->device
            ? $this->device->update($data)
            : Device::create($data);

        session()->flash('message', 'Пристрій успішно збережено.');

        return redirect()->route('devices.index');
    }

    public function render()
    {
        return view('livewire.devices.device-form');
    }
}
