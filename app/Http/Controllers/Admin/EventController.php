<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('creator')->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'description'=> 'required|string',
            'event_date' => 'required|date',
            'location'   => 'nullable|string|max:255',
        ]);

        try {
            Event::create([
                'title'       => $request->title,
                'description' => $request->description,
                'event_date'  => \Carbon\Carbon::parse($request->event_date),
                'location'    => $request->location,
                'is_active'   => $request->has('is_active'),
                'created_by'  => auth()->id(),
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['event_date' => 'Invalid date format. Please use the date picker.']);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title'      => 'required|string|max:255',
            'description'=> 'required|string',
            'event_date' => 'required|date',
            'location'   => 'nullable|string|max:255',
        ]);

        try {
            $event->update([
                'title'       => $request->title,
                'description' => $request->description,
                'event_date'  => \Carbon\Carbon::parse($request->event_date),
                'location'    => $request->location,
                'is_active'   => $request->has('is_active'),
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['event_date' => 'Invalid date or time format. Please check the input and try again.']);
        }

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
