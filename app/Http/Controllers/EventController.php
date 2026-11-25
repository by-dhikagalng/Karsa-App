<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    // Menampilkan katalog event dengan filter kategori, eager loading, dan pagination
    public function index(Request $request)
    {
        $category = $request->query('category');

        // Kategori yang tidak dikenal diabaikan dan dianggap "Semua"
        if (! array_key_exists((string) $category, Event::CATEGORIES)) {
            $category = null;
        }

        // Bagian Arya: jika ?category tidak ada, ambil dari cookie kategori terakhir, lalu simpan pilihan ke cookie

        $events = Event::with('organization')
            ->when($category, fn ($query) => $query->where('category', $category))
            ->orderBy('event_date')
            ->paginate(6)
            ->withQueryString();

        return view('events.index', [
            'events' => $events,
            'categories' => Event::CATEGORIES,
            'selectedCategory' => $category,
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
