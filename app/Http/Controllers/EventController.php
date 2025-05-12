<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index');
    }

    public function create()
{
    $this->authorize('create', Event::class);

    return view('events.create');
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'date'             => 'required|date',
            'location'         => 'required|string|max:255',
            'max_participants' => 'required|integer|min:1',
        ]);

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Подія створена успішно!');
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'date'             => 'required|date',
            'location'         => 'required|string|max:255',
            'max_participants' => 'required|integer|min:1',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Подія оновлена успішно!');
    }
}
