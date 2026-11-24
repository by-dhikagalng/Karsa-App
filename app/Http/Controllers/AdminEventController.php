<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    // Menampilkan daftar event: admin ormawa hanya miliknya, super admin semua
    public function index()
    {
        $user = auth()->user();

        $events = Event::with('organization')
            ->when(! $user->isSuperAdmin(), fn ($query) => $query->where('organization_id', $user->organization_id))
            ->orderByDesc('event_date')
            ->paginate(10);

        return view('admin.events.index', [
            'events' => $events,
            'categories' => Event::CATEGORIES,
        ]);
    }

    public function create()
    {
        return 'TODO admin event create Ayya';
    }

    public function store()
    {
        return 'TODO admin event store data Ayya';
    }

    public function edit()
    {
        return 'TODO admin event edit data Ayya';
    }

    public function update()
    {
        return 'TODO admin event update data Ayya';
    }

    public function destroy()
    {
        return 'TODO admin event delete data Ayya';
    }
}