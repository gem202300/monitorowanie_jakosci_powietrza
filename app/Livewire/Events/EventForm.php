<?php
namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class EventForm extends Component
{
    use WireUiActions;

    public Event $event;
    public $name = '';
    public $date = '';
    public $location = '';
    public $max_participants = '';
    public $description = '';

    public function mount(Event $event = null)
    {
        $this->event = $event ?? new Event();

        if (isset($this->event->id)) {
            $this->name             = $this->event->name;
            $this->date             = $this->event->date;
            $this->location         = $this->event->location;
            $this->max_participants = $this->event->max_participants;
            $this->description      = $this->event->description;
        }
    }

    public function submit()
    {
        if (isset($this->event->id)) {
            $this->authorize('update', $this->event);
        } else {
            $this->authorize('create', Event::class);
        }

        Event::updateOrCreate(
            ['id' => optional($this->event)->id],
            $this->validate()
        );

        flash(
            isset($this->event->id)
                ? __('translation.messages.successes.updated_title')
                : __('translation.messages.successes.stored_title'),
            isset($this->event->id)
                ? __('events.messages.successes.updated', ['name' => $this->name])
                : __('events.messages.successes.stored', ['name' => $this->name]),
            'success'
        );

        return $this->redirect(route('events.index'));
    }

    public function rules()
{
    $minParticipants = isset($this->event->id) ? $this->event->reservations()->count() : 1;

    return [
        'name'             => ['required', 'string', 'min:2', 'unique:events,name' . (isset($this->event->id) ? (',' . $this->event->id) : '')],
        'description'      => ['required', 'string'],
        'date'             => ['required', 'date'],
        'location'         => ['required', 'string', 'min:2'],
        'max_participants' => ['required', 'integer', "min:$minParticipants"],
    ];
}

    public function validationAttributes()
    {
        return [
            'name'             => __('events.attributes.name'),
            'description'      => __('events.attributes.description'),
            'date'             => __('events.attributes.date'),
            'location'         => __('events.attributes.location'),
            'max_participants' => __('events.attributes.max_participants'),
        ];
    }

    public function render()
    {
        return view('livewire.events.event-form');
    }
}
