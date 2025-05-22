<?php

namespace App\Livewire\Parameters;

use App\Models\Parameter;
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

final class ParameterTable extends PowerGridComponent
{
    use AuthorizesRequests, WireUiActions, WithExport;

    #[\Livewire\Attributes\On('deleteParameterAction')]
    public function deleteParameterAction(Parameter $parameter): void
    {
        $this->dialog()->confirm([
            'title'       => __('Usuń urządzenie'),
            'description' => __('Czy na pewno chcesz usunąć urządzenie ":name"?', ['name' => $parameter->name]),
            'icon'        => 'warning',
            'accept'      => [
                'label'  => 'Tak',
                'method' => 'destroy',
                'params' => $parameter,
            ],
            'reject' => [
                'label' => 'Nie',
            ],
        ]);
    }

    public function destroy(Parameter $parameter)
    {
        $this->authorize('delete', $parameter);

        $parameter->delete();

        $this->notification()->success(
            'Sukces',
            __('Urządzenie ":name" zostało usunięte.', ['name' => $parameter->name])
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
        return Parameter::query();
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
            ->add('label')
            ->add('unit')
            ->add('valueType')
            ->add('created_at')
            ->add('created_at_formatted', fn ($parameter) => Carbon::parse($parameter->created_at)->format('Y-m-d H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('ID'), 'id')->sortable()->searchable(),
            Column::make(__('Nazwa'), 'name')->sortable()->searchable(),
            Column::make(__('Label'), 'label')->sortable()->searchable(),
            Column::make(__('Unit'), 'unit')->sortable()->searchable(),
            Column::make(__('Value Type'), 'valueType')->sortable()->searchable(),
            Column::make(__('Utworzono'), 'created_at_formatted', 'created_at')->sortable(),
            Column::action(__('Akcje')),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder('Nazwa')->operators(['contains']),
            Filter::inputText('label')->placeholder('Label')->operators(['contains']),
            Filter::inputText('unit')->placeholder('Unit')->operators(['contains']),
            Filter::inputText('valueType')->placeholder('Value Type')->operators(['contains']),
            Filter::datetimepicker('created_at', 'created_at'),
        ];
    }

    public function actions(Parameter $parameter): array
    {
        return [
            // Button::add('editParameter')
            //     ->route('parameters.edit', [$parameter])
            //     ->slot('<svg class="w-5 h-5" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l10-10-5.5-5.5-10 10z"/></svg>')
            //     ->tooltip('Edytuj')
            //     ->class('text-gray-500')
            //     ->method('get')
            //     ->can(Auth::check() && Auth::user()->can('update', $parameter))
            //     ->target('_self'),

            Button::add('deleteParameterAction')
                ->slot('<x-wireui-icon name="trash" class="w-5 h-5" mini />') // заміни на свою іконку
                ->tooltip('Usuń')
                ->class('text-red-500')
                ->can(Auth::user()->can('delete', $parameter))
                ->dispatch('deleteParameterAction', ['parameter' => $parameter]),
        ];
    }

    public function actionRules($parameter): array
    {
        return [];
    }
}
