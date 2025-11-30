<?php

namespace App\Livewire\Devices;

use App\Models\Device;
use Illuminate\Support\Carbon;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;

use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class DeviceTable extends PowerGridComponent
{
    use AuthorizesRequests, WireUiActions, WithExport;

    #[\Livewire\Attributes\On('deleteDeviceAction')]
    public function deleteDeviceAction(Device $device): void
    {
        $this->dialog()->confirm([
            'title'       => __('Usuń urządzenie'),
            'description' => __('Czy na pewno chcesz usunąć urządzenie ":name"?', ['name' => $device->name]),
            'icon'        => 'warning',
            'accept'      => [
                'label'  => 'Tak',
                'method' => 'destroy',
                'params' => $device,
            ],
            'reject' => [
                'label' => 'Nie',
            ],
        ]);
    }

    public function destroy(Device $device)
    {
        $this->authorize('delete', $device);

        $device->delete();

        $this->notification()->success(
            'Sukces',
            __('Urządzenie ":name" zostało usunięte.', ['name' => $device->name])
        );

        $this->dispatch('pg:refresh');
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('Eksport')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

    public function dataSource(): Builder
    {
        $query = Device::query()->with('users');



        return $query;
    }

    public function relationSearch(): array
    {
        return [];
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
            ->add('created_at_formatted', fn($device) => Carbon::parse($device->created_at)->format('Y-m-d H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('devices.attributes.id'), 'id')->sortable()->searchable(),
            Column::make(__('devices.attributes.name'), 'name')->sortable()->searchable(),
            Column::make(__('devices.attributes.status'), 'status')->sortable()->searchable(),
            Column::make(__('devices.attributes.address'), 'address')->sortable()->searchable(),
            Column::make(__('devices.attributes.longitude'), 'longitude')->sortable()->searchable(),
            Column::make(__('devices.attributes.latitude'), 'latitude')->sortable()->searchable(),
            Column::make(__('devices.attributes.created_at'), 'created_at_formatted', 'created_at')->sortable(),
            Column::action(__('devices.attributes.actions')),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder(__('translation.placeholder.enter'))->operators(['contains']),
            Filter::inputText('status')->placeholder(__('translation.placeholder.enter'))->operators(['contains']),
            Filter::inputText('address')->placeholder(__('translation.placeholder.enter'))->operators(['contains']),
            Filter::inputText('longitude')->placeholder(__('translation.placeholder.enter'))->operators(['contains']),
            Filter::inputText('latitude')->placeholder(__('translation.placeholder.enter'))->operators(['contains']),
            Filter::datetimepicker('created_at', 'created_at'),
        ];
    }

    public function actions(Device $device): array
    {
        $isMine = $device->users->contains(Auth::id());
        return [
            Button::add('showMeasurement')
                ->slot('<x-wireui-icon name="chart-bar" class="w-5 h-5" />')
                ->route('devices.measurements', ['device' => $device->id]),
            Button::add('showRepairs')
                ->slot('<x-wireui-icon name="clock" class="w-5 h-5" />')
                ->tooltip('Historia awarii i napraw')
                ->class('text-blue-500')
                ->route('devices.repairs', ['device' => $device->id])
                ->method('get')
                ->target('_self'),
            Button::add('editDevice')
                ->route('devices.edit', [$device])
                ->slot('<svg class="w-5 h-5" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l10-10-5.5-5.5-10 10z"/></svg>')
                ->tooltip('Edytuj')
                ->class('text-gray-500')
                ->method('get')
                ->can((Auth::user()->hasRole('admin') || $isMine) && Auth::user()->can('update', $device))
                ->target('_self'),
            Button::add('deleteDeviceAction')
                ->slot('<x-wireui-icon name="trash" class="w-5 h-5" mini />')
                ->tooltip('Usuń')
                ->class('text-red-500')
                ->can((Auth::user()->hasRole('admin') || $isMine) && Auth::user()->can('delete', $device))
                ->dispatch('deleteDeviceAction', ['device' => $device]),
             Button::add('showHistory')
                ->slot('<x-wireui-icon name="users" class="w-5 h-5" />')
                ->tooltip('Historia przypisań')
                ->class('text-purple-500 hover:text-purple-700')
                ->route('devices.history', ['device' => $device->id])
                ->method('get')
                ->target('_self'),


        ];
    }

    public function actionRules($device): array
    {
        return [];
    }
}