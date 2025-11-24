<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index');
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3',
            'description' => 'required',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date',
            'end_time' => 'required',
            'venue' => 'required',
            'type' => 'required|in:social,academic,training,workshop,seminar,other',
        ]);

        // Combine date and time
        $startDateTime = $validated['start_date'] . ' ' . $validated['start_time'];
        $endDateTime = $validated['end_date'] . ' ' . $validated['end_time'];

        $event = Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $startDateTime,
            'end_date' => $endDateTime,
            'venue' => $validated['venue'],
            'type' => $validated['type'],
            'status' => 'upcoming',
            'created_by' => Auth::id()
        ]);

        return redirect()->route('events.show', $event)
            ->with('message', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|min:3',
            'description' => 'required',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date',
            'end_time' => 'required',
            'venue' => 'required',
            'type' => 'required|in:social,academic,training,workshop,seminar,other',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        // Combine date and time
        $startDateTime = $validated['start_date'] . ' ' . $validated['start_time'];
        $endDateTime = $validated['end_date'] . ' ' . $validated['end_time'];

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $startDateTime,
            'end_date' => $endDateTime,
            'venue' => $validated['venue'],
            'type' => $validated['type'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('events.show', $event)
            ->with('message', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // if (!Auth::user()->canDelete()) {
        //     return redirect()->route('events.show', $event)
        //         ->with('error', 'You do not have permission to delete events.');
        // }

        $event->delete();

        return redirect()->route('events.index')
            ->with('message', 'Event deleted successfully.');
    }
}
