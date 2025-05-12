<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Reservation;
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

final class EventTable extends PowerGridComponent
{
    use AuthorizesRequests, WireUiActions, WithExport;

    protected $listeners = [
        'registerAction',
        'confirmRegistration',
        'unregisterAction',
        'confirmUnregistration',
    ];

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
        return Event::query()->withCount('reservations');
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
            ->add('date')
            ->add('location')
            ->add('max_participants')
            ->add('reservations_count')
            ->add('registered_info', function ($event) {
                return $event->reservations_count . '/' . $event->max_participants;
            })
            ->add('confirmation_date', function ($event) {
                return Carbon::parse($event->created_at)->format('Y-m-d H:i');
            })
            ->add('created_at')
            ->add('created_at_formatted', function ($event) {
                return Carbon::parse($event->created_at)->format('Y-m-d H:i');
            });
    }

  
    public function columns(): array
    {
        return [
            Column::make(__('events.attributes.id'), 'id')
                ->sortable()
                ->searchable(),
            Column::make(__('events.attributes.name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('events.attributes.date'), 'date')
                ->sortable()
                ->searchable(),
            Column::make(__('events.attributes.location'), 'location')
                ->sortable()
                ->searchable(),
            Column::make(__('events.attributes.registered_count'), 'registered_info', 'reservations_count')
                ->sortable()
                ->searchable(),
            Column::make(__('events.attributes.created_at'), 'created_at_formatted', 'created_at')
                ->sortable()
                ->searchable(),
            Column::action(__('events.actions.actions')),
        ];
    }

    
    public function filters(): array
    {
        return [
            Filter::inputText('name')
                ->placeholder(__('events.attributes.name'))
                ->operators(['contains']),
            Filter::inputText('location')
                ->placeholder(__('events.attributes.location'))
                ->operators(['contains']),
            Filter::inputText('date')
                ->placeholder(__('events.attributes.date'))
                ->operators(['contains']),
            Filter::inputText('max_participants')
                ->placeholder(__('events.attributes.max_participants'))
                ->operators(['contains']),
            Filter::inputText('reservations_count')
                ->placeholder(__('events.attributes.registered_count'))
                ->operators(['contains']),
            Filter::datetimepicker('created_at', 'created_at'),
        ];
    }

    
    public function actions(Event $event): array
    {
        $userRegistered = Reservation::where('id_wydarzenia', $event->id)
            ->where('id_uzytkownika', Auth::id())
            ->exists();

        $buttons = [
            Button::add('editAction')
                ->route('events.edit', [$event])
                ->slot('<x-wireui-icon name="pencil-square" class="w-5 h-5" mini />')
                ->tooltip(__('events.actions.edit'))
                ->class('text-gray-500')
                ->method('get')
                ->can(Auth::user()->can('update', $event))
                ->target('_self'),
            Button::add('destroyAction')
                ->slot('<x-wireui-icon name="trash" class="w-5 h-5" mini />')
                ->tooltip(__('events.actions.destroy'))
                ->class('text-gray-500')
                ->can(Auth::user()->can('delete', $event))
                ->dispatch('destroyAction', ['event' => $event]),
        ];

       if (Auth::user()->isAdmin() || Auth::user()->isWorker()) {
            $buttons[] = Button::add('viewReservations')
                ->route('reservations.index', ['event' => $event->id])
                ->slot('<x-wireui-icon name="eye" class="w-5 h-5" mini />')
                ->tooltip(__('events.actions.view_reservations'))
                ->class('text-green-500');
        }

        if ($userRegistered) {
            $buttons[] = Button::add('unregisterAction')
                ->slot('<x-wireui-icon name="user-minus" class="w-5 h-5" mini />')
                ->tooltip('Anuluj rejestrację')
                ->class('text-red-500')
                ->dispatch('unregisterAction', ['id' => $event->id]);
        } else {
            $buttons[] = Button::add('registerAction')
                ->slot('<x-wireui-icon name="user-plus" class="w-5 h-5" mini />')
                ->tooltip('Zarejestruj się')
                ->class('text-blue-500')
                ->dispatch('registerAction', ['id' => $event->id])
                ->can($event->reservations_count < $event->max_participants);
        }

        return $buttons;
    }

    public function actionRules($event): array
    {
        return [];
    }

    #[\Livewire\Attributes\On('destroyAction')]
    public function destroyAction(Event $event): void
    {
        $this->dialog()->confirm([
            'title'       => __('events.dialogs.delete.title'),
            'description' => __('events.dialogs.delete.description', ['name' => $event->name]),
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Tak',
                'method' => 'destroy',
                'params' => $event,
            ],
            'reject' => [
                'label' => 'Nie',
            ],
        ]);
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        $this->notification()->success(
            'Sukces',
            __('events.messages.successes.destroyed', ['name' => $event->name])
        );
    }

    public function registerAction($id): void
    {
        $event = Event::findOrFail($id);
        $this->dialog()->confirm([
            'title'       => 'Potwierdź rejestrację',
            'description' => __('Czy chcesz zarejestrować się na wydarzenie :name?', ['name' => $event->name]),
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Tak',
                'method' => 'confirmRegistration',
                'params' => $id,
            ],
            'reject' => [
                'label' => 'Nie',
            ],
        ]);
    }


    public function confirmRegistration($id): void
    {
        $event = Event::findOrFail($id);
        $event->loadCount('reservations');

        $existing = Reservation::where('id_wydarzenia', $id)
            ->where('id_uzytkownika', Auth::id())
            ->first();

        if ($existing) {
            $this->notification()->error(
                'Błąd',
                __('events.messages.errors.already_registered')
            );
            return;
        }

        if ($event->reservations_count >= $event->max_participants) {
            $this->notification()->error(
                'Błąd',
                __('events.messages.errors.event_full')
            );
            return;
        }

        Reservation::create([
            'id_wydarzenia'   => $id,
            'id_uzytkownika'  => Auth::id(),
            'data_rezerwacji' => now(),
        ]);

        $this->notification()->success(
            'Sukces',
            __('events.messages.successes.registered', ['name' => $event->name])
        );

        $this->dispatch('pg:refresh');
    }

    
    public function unregisterAction($id): void
    {
        $event = Event::findOrFail($id);
        $this->dialog()->confirm([
            'title'       => 'Potwierdź anulowanie rejestracji',
            'description' => __('Czy chcesz anulować rejestrację na wydarzenie :name?', ['name' => $event->name]),
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Tak',
                'method' => 'confirmUnregistration',
                'params' => $id,
            ],
            'reject' => [
                'label' => 'Nie',
            ],
        ]);
    }


    public function confirmUnregistration($id): void
    {
        $reservation = Reservation::where('id_wydarzenia', $id)
            ->where('id_uzytkownika', Auth::id())
            ->first();

        if (!$reservation) {
            $this->notification()->error(
                'Błąd',
                'Nie jesteś zarejestrowany na to wydarzenie.'
            );
            return;
        }

        $reservation->delete();
        $this->notification()->success(
            'Sukces',
            'Anulowano rejestrację na wydarzenie.'
        );

        $this->dispatch('pg:refresh');
    }
}
