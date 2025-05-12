<?php

namespace App\Livewire\Reservations;

use App\Models\Reservation;
use Illuminate\Support\Carbon;
use WireUi\Traits\WireUiActions;
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
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class ReservationTable extends PowerGridComponent
{
    use WithExport, WireUiActions;

    
    public $event;

   
    protected $queryString = ['event'];

    
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()->showPerPage()->showRecordCount(),
        ];
    }

   
    public function dataSource(): Builder
    {
        $query = Reservation::query()
            ->select(
                'reservations.*',
                'users.name as user_name',
                'events.name as event_name'
            )
            ->join('users', 'users.id', '=', 'reservations.id_uzytkownika')
            ->join('events', 'events.id', '=', 'reservations.id_wydarzenia');

        if ($this->event) {
            $query->where('reservations.id_wydarzenia', $this->event);
        }

        if (!(auth()->user()->isAdmin() || auth()->user()->isWorker())) {
            $query->where('reservations.id_uzytkownika', auth()->id());
        }

        return $query;
    }

    
    public function relationSearch(): array
    {
        return [
            'user'  => ['name', 'email'],
            'event' => ['name', 'description'],
        ];
    }

    
    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('id_uzytkownika')
            ->add('id_wydarzenia')
            ->add('data_rezerwacji')
            ->add('data_rezerwacji_formatted', function ($reservation) {
                return Carbon::parse($reservation->data_rezerwacji)->format('Y-m-d H:i');
            })
            ->add('user_name')
            ->add('event_name');
    }

    
    public function columns(): array
    {
        return [
            Column::make(__('reservations.attributes.id'), 'id', 'reservations.id')
                ->sortable()
                ->searchable(),
            Column::make(__('reservations.attributes.data_rezerwacji'), 'data_rezerwacji_formatted', 'data_rezerwacji')
                ->sortable()
                ->searchable(),
            Column::make(__('reservations.attributes.user_name'), 'user_name', 'users.name')
                ->sortable()
                ->searchable(),
            Column::make(__('reservations.attributes.event_name'), 'event_name', 'events.name')
                ->sortable()
                ->searchable(),
            Column::action('Akcje'),
        ];
    }

    
    public function filters(): array
    {
        return [
            Filter::inputText('reservations.id')
                ->placeholder(__('reservations.placeholder.enter')),
            Filter::datetimepicker('data_rezerwacji', 'data_rezerwacji'),
            Filter::inputText('users.name')
                ->placeholder(__('reservations.placeholder.enter')),
            Filter::inputText('events.name')
                ->placeholder(__('reservations.placeholder.enter')),
        ];
    }

    
    public function emptyMessage(): string
    {
        return 'Brak rezerwacji do wyświetlenia.';
    }

  
    #[\Livewire\Attributes\On('deleteReservationAction')]
    public function deleteReservationAction($id): void
    {
        $reservation = Reservation::findOrFail($id);

        if (!(auth()->user()->isAdmin() || auth()->user()->isWorker() || $reservation->id_uzytkownika == auth()->id())) {
            abort(403, __('Brak uprawnień.'));
        }

        $reservation->delete();

        $this->notification()->success(
            __('Sukces'),
            __('Rezerwacja została pomyślnie usunięta.')
        );

       $this->dispatch('pg:refresh');
    }

   
    public function actions(Reservation $reservation): array
    {
        return [
            Button::add('deleteReservationAction')
                ->slot('<x-wireui-icon name="trash" class="w-5 h-5" mini />')
                ->tooltip(__('reservations.actions.delete'))
                ->class('text-red-500')
                ->dispatch('deleteReservationAction', ['id' => $reservation->id])
                ->can(auth()->user()->isAdmin() || auth()->user()->isWorker() || $reservation->id_uzytkownika == auth()->id()),
        ];
    }
}
