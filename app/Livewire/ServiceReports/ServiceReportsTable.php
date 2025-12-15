<?php

namespace App\Livewire\ServiceReports;

use App\Models\DeviceReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Button;
use WireUi\Traits\WireUiActions;

final class ServiceReportsTable extends PowerGridComponent
{
    use WireUiActions;

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

        // Get only devices with 4 or more reports (inactive devices)
        // Group by device and show as single entry per device
        return DeviceReport::query()
            ->select(
                'device_reports.device_id as id',  // Alias device_id as id for PowerGrid
                'device_reports.device_id',
                'devices.name as device_name',
                'devices.status as device_status',
                'devices.address as device_address',
                DB::raw('COUNT(device_reports.id) as reports_count'),
                DB::raw('MIN(device_reports.created_at) as first_report_date'),
                DB::raw('MAX(device_reports.created_at) as latest_report_date'),
                DB::raw('GROUP_CONCAT(device_reports.reason SEPARATOR ", ") as all_reasons')
            )
            ->join('devices', 'devices.id', '=', 'device_reports.device_id')
            ->join('user_devices', 'user_devices.device_id', '=', 'devices.id')
            ->where('user_devices.user_id', $user->id)
            ->where(function ($query) {
                $query->whereNull('user_devices.unassign_at')
                      ->orWhere('user_devices.unassign_at', '>', now());
            })
            ->groupBy('device_reports.device_id', 'devices.name', 'devices.status', 'devices.address')
            ->havingRaw('COUNT(device_reports.id) >= 4')
            ->orderByRaw('MAX(device_reports.created_at) DESC');
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
            ->add('device_id')
            ->add('device_name')
            ->add('device_status')
            ->add('device_address')
            ->add('reports_count')
            ->add('all_reasons')
            ->add('first_report_date')
            ->add('latest_report_date')
            ->add('latest_report_formatted', fn($row) => Carbon::parse($row->latest_report_date)->format('Y-m-d H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('service_reports.device'), 'device_name')
                ->searchable()
                ->sortable(),

            Column::make(__('service_reports.device_status'), 'device_status')
                ->sortable(),

            Column::make(__('service_reports.reports_count'), 'reports_count')
                ->sortable(),

            Column::make(__('service_reports.all_reasons'), 'all_reasons')
                ->searchable(),

            Column::make(__('service_reports.latest_report'), 'latest_report_formatted')
                ->sortable(),

            Column::action(__('service_reports.actions'))
        ];
    }

    public function actions($row): array
    {
        return [
            Button::add('view')
                ->slot(__('service_reports.resolve'))
                ->class('bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded')
                ->route('service-reports.show', ['device' => $row->device_id]),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('device_name')->operators(['contains']),
            Filter::inputText('all_reasons')->operators(['contains']),
        ];
    }
}

