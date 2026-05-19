<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;
class EventController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'institute') {
            $events = auth()->user()->company->events ?? collect();
            return view('institute.events.index', compact('events'));
        }

        $events = Event::with('company')->get();
        return view('candidate.events.index', compact('events'));
    }

    public function create()
    {
        return view('institute.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'link' => 'nullable|url',
        ]);

        auth()->user()->company->events()->create($request->all());

        return redirect()->route('events.index')->with('success', 'Event scheduled!');
    }

    public function edit(Event $event)
    {
        if ($event->company_id !== auth()->user()->company->id) {
            abort(403);
        }
        return view('institute.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'link' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        if ($event->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
}
