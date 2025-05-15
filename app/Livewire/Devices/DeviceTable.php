<?php

namespace App\Livewire\Devices;

use App\Models\Device;
use PowerComponents\LivewirePowerGrid\Actions\EditAction;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\{Button, Column, PowerGrid, PowerGridComponent, PowerGridFields};

class DeviceTable extends PowerGridComponent
{
    public function setUp(): array
    {
        return [
            \PowerComponents\LivewirePowerGrid\Header::make()->showSearchInput(),
            \PowerComponents\LivewirePowerGrid\Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

    public function dataSource(): \Illuminate\Database\Eloquent\Builder
    {
        return Device::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('status')
            ->add('address')
            ->add('longitude')
            ->add('latitude')
            ->add('created_at_formatted', fn ($device) => Carbon::parse($device->created_at)->format('Y-m-d H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Status', 'status')->sortable()->searchable(),
            Column::make('Address', 'address')->sortable()->searchable(),
            Column::make('Longitude', 'longitude'),
            Column::make('Latitude', 'latitude'),
            Column::make('Created At', 'created_at_formatted', 'created_at')->sortable(),
            Column::action('Actions'),
        ];
    }

    public function actions(Device $device): array
    {
        return [
           Button::add('editDevice')
            ->slot('✏️')
            ->tooltip('Редагувати пристрій')
            ->class('text-blue-500')
            ->route('devices.edit', ['device' => $device->id]),
        ];
    }

    #[\Livewire\Attributes\On('deleteDeviceAction')]
    public function deleteDeviceAction($id): void
    {
        $device = Device::findOrFail($id);
        $device->delete();

        $this->notification()->success('Success', 'Device deleted');
        $this->dispatch('pg:refresh'); // оновити таблицю
    }

    #[\Livewire\Attributes\On('editDeviceAction')]
    public function editDeviceAction($id): void
    {
        $this->dispatch('openEditModal', ['id' => $id]); // відкриваємо модалку з формою
    }
}
