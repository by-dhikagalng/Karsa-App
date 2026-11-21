<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('organization')->orderBy('event_date')->paginate(9)->withQueryString();

        return view('events.index', [
            'events' => $events,
            'categories' => Event::CATEGORIES,
        ]);
    }

    public function show(Event $event)
    {
        $event->load('organization');

        return view('events.show', [
            'event' => $event,
        ]);
    }

    public function schedule()
    {
        $groupedEvents = Event::with('organization')->orderBy('event_date')->get()->groupBy(fn ($event) => $event->event_date->toDateString());

        return view('events.schedule', [
            'groupedEvents' => $groupedEvents,
        ]);
    }

    public function poster(Event $event)
    {
        return 'TODO Tugas Poster (Arya)';
    }
}
