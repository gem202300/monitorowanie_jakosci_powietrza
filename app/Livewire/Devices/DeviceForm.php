<?php

namespace App\Livewire\Devices;


use App\Models\Device;
use Livewire\Component;
use App\Models\Parameter;
use WireUi\Traits\WireUiActions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeviceForm extends Component
{
    use AuthorizesRequests, WireUiActions;

    public $selectedParameters = [];
    public $parameters = [];

    public ?Device $device;
    public $name = '';
    public $status = 'active';
    public $address = '';
    public $longitude = '';
    public $latitude = '';

    public function mount(Device $device = null)
{
    $this->device = $device ?? new Device();

    $this->parameters = Parameter::all()->map(function ($param) {
        return [
            'id' => $param->id,
            'label' => "{$param->label} ({$param->unit})",
        ];
    })->toArray();

    if ($this->device->exists) {
        $this->name = $this->device->name;
        $this->status = $this->device->status;
        $this->address = $this->device->address;
        $this->longitude = $this->device->longitude;
        $this->latitude = $this->device->latitude;

        $this->selectedParameters = $this->device->parameters()->pluck('parameters.id')->toArray();
    }
}

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,maintenance,inactive'],
            'address' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'numeric', 'min:-180', 'max:180'],
            'latitude' => ['required', 'numeric', 'min:-90', 'max:90'],
            'selectedParameters' => ['required', 'array'],
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => __('devices.attributes.name'),
            'status' => __('devices.attributes.status'),
            'address' => __('devices.attributes.address'),
            'longitude' => __('devices.attributes.longitude'),
            'latitude' => __('devices.attributes.latitude'),
            'selectedParameters' => __('devices.attributes.parameters'),
        ];
    }

    public function submit()
    {
        if ($this->device->exists) {
            $this->authorize('update', $this->device);
        } else {
            $this->authorize('create', Device::class);
        }

        $this->longitude = str_replace(',', '.', $this->longitude);
        $this->latitude = str_replace(',', '.', $this->latitude);

        $this->validate();

        Device::updateOrCreate(
            ['id' => $this->device->id ?? null],
            $this->only(['name', 'status', 'address', 'longitude', 'latitude'])
        );
        $device = Device::updateOrCreate(
            ['id' => $this->device->id ?? null],
            $this->only(['name', 'status', 'address', 'longitude', 'latitude'])
        );

        $device->parameters()->sync($this->selectedParameters);
        flash(
            $this->device->exists
                ? __('translation.messages.successes.updated_title')
                : __('translation.messages.successes.stored_title'),
            $this->device->exists
                ? __('devices.messages.successes.updated', ['name' => $this->name])
                : __('devices.messages.successes.stored', ['name' => $this->name]),
            'success'
        );

        return redirect()->route('devices.index');
    }
    

 
    public function render()
    {
        return view('livewire.devices.device-form');
    }
}
