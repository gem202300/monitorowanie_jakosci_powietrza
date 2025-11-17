<?php

namespace App\Livewire\DeviceReports;

use App\Models\Device;
use App\Models\DeviceReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGrid;

final class DeviceReportsTable extends PowerGridComponent
{
    public function setUp(): array
    {
        return [
            Header::make()->showSearchInput(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $user = Auth::user();

        return DeviceReport::query()
            ->select('device_reports.*')
            ->join('devices', 'devices.id', '=', 'device_reports.device_id')
            ->join('user_devices', 'user_devices.device_id', '=', 'devices.id')
            ->where('user_devices.user_id', $user->id)
            ->where(function ($query) {
                $query->whereNull('user_devices.unassign_at')
                      ->orWhere('user_devices.unassign_at', '>', now());
            })
            ->orderByDesc('device_reports.created_at');
    }

    public function relationSearch(): array
    {
        return [
            'device' => ['name'],
            'user'   => ['name'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('device_name', fn($report) => $report->device->name)
            ->add('reason')
            ->add('description')
            ->add('user_name', fn($report) => $report->user->name)
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),

            Column::make('Urządzenie', 'device_name')
                ->searchable()
                ->sortable(),

            Column::make('Powód', 'reason')
                ->searchable()
                ->sortable(),

            Column::make('Opis', 'description')
                ->searchable()
                ->sortable(),

            Column::make('Zgłoszone przez', 'user_name')
                ->searchable()
                ->sortable(),

            Column::make('Data', 'created_at')
                ->sortable()
                ->searchable()
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('reason')->operators(['contains']),
            Filter::inputText('description')->operators(['contains']),
            Filter::inputText('device_name')->operators(['contains']),
        ];
    }
}
