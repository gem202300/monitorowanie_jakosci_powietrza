<?php

namespace App\Livewire\Devices;

use App\Models\Device;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Footer;

final class DeviceTable extends PowerGridComponent
{
    public function setUp(): array
    {
        return [
            Exportable::make('devices_export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

    public function dataSource(): Builder
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
            ->add('created_at')
            ->add('created_at_formatted', fn ($device) => $device->created_at->format('Y-m-d H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Address', 'address')
                ->sortable()
                ->searchable(),

            Column::make('Longitude', 'longitude')
                ->sortable(),

            Column::make('Latitude', 'latitude')
                ->sortable(),

            Column::make('Created At', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }
}
