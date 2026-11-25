<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $validCategories = array_keys(Event::CATEGORIES);
        $selectedCategory = null;

        if ($request->has('category')) {
            $categoryInput = $request->query('category');

            if ($categoryInput === '' || $categoryInput === null) { // User memilih "Semua Kategori": hapus cookie       
                Cookie::queue(Cookie::forget('last_category'));
            } elseif (in_array($categoryInput, $validCategories, true)) {
                
                $selectedCategory = $categoryInput;
                Cookie::queue('last_category', $selectedCategory, 60 * 24 * 7);// Simpan kategori valid ke cookie selama 7 hari
            }
        } else {
            // Jika tidak ada query ?category=, baca dari cookie
            $cookieCategory = $request->cookie('last_category');
            if ($cookieCategory && in_array($cookieCategory, $validCategories, true)) {
                $selectedCategory = $cookieCategory;
            }
        }

        $events = Event::with('organization')
            ->when($selectedCategory, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->orderBy('event_date')
            ->paginate(6)
            ->withQueryString();

        return view('events.index', [
            'events' => $events,
            'categories' => Event::CATEGORIES,
            'selectedCategory' => $selectedCategory,
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
        $groupedEvents = Event::with('organization')
            ->orderBy('event_date')
            ->get()
            ->groupBy(fn ($event) => $event->event_date->toDateString());

        return view('events.schedule', [
            'groupedEvents' => $groupedEvents,
        ]);
    }

    public function poster(Event $event)
    {
        // Pastikan kolom poster_path terisi dan file fisiknya ada di public/
        if (empty($event->poster_path)) {
            abort(404, 'Poster tidak tersedia untuk event ini.');
        }

        $filePath = public_path($event->poster_path);

        if (!file_exists($filePath) || !is_file($filePath)) {
            abort(404, 'Berkas poster tidak ditemukan di server.');
        }

        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $downloadName = Str::slug($event->title) . '-poster.' . $extension;

        return response()->download($filePath, $downloadName);
    }

}
