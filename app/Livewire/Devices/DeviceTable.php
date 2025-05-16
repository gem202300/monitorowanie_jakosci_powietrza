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
        return Device::query();
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
            ->add('created_at_formatted', fn ($device) => Carbon::parse($device->created_at)->format('Y-m-d H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), 'id')->sortable()->searchable(),
            Column::make(__('Nazwa'), 'name')->sortable()->searchable(),
            Column::make(__('Status'), 'status')->sortable()->searchable(),
            Column::make(__('Adres'), 'address')->sortable()->searchable(),
            Column::make(__('Długość geograficzna'), 'longitude')->sortable()->searchable(),
            Column::make(__('Szerokość geograficzna'), 'latitude')->sortable()->searchable(),
            Column::make(__('Utworzono'), 'created_at_formatted', 'created_at')->sortable(),
            Column::action(__('Akcje')),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder('Nazwa')->operators(['contains']),
            Filter::inputText('status')->placeholder('Status')->operators(['contains']),
            Filter::inputText('address')->placeholder('Adres')->operators(['contains']),
            Filter::inputText('longitude')->placeholder('Długość geograficzna')->operators(['contains']),
            Filter::inputText('latitude')->placeholder('Szerokość geograficzna')->operators(['contains']),
            Filter::datetimepicker('created_at', 'created_at'),
        ];
    }

    public function actions(Device $device): array
    {
        return [
            Button::add('showMeasurement')
                //->caption('Show Measurements')
                ->class('bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded')
                ->route('devices.measurements', ['device' => $device->id]),
            Button::add('editDevice')
                ->route('devices.edit', [$device])
                ->slot('<svg class="w-5 h-5" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l10-10-5.5-5.5-10 10z"/></svg>')
                ->tooltip('Edytuj')
                ->class('text-gray-500')
                ->method('get')
                ->can(Auth::check() && Auth::user()->can('update', $device))
                ->target('_self'),

            Button::add('deleteDeviceAction')
                ->slot('<x-wireui-icon name="trash" class="w-5 h-5" mini />') // заміни на свою іконку
                ->tooltip('Usuń')
                ->class('text-red-500')
                ->can(Auth::user()->can('delete', $device))
                ->dispatch('deleteDeviceAction', ['device' => $device]),
        ];
    }

    public function actionRules($device): array
    {
        return [];
    }
}
