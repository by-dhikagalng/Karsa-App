@extends('layouts.app')

@section('title', 'Jadwal Event')

@section('content')

@php
    $categories = [
        'seminar'  => 'Seminar, Pelatihan, dan Workshop',
        'lomba'    => 'Lomba',
        'beasiswa' => 'Beasiswa dan Lainnya',
    ];

    $tgl = fn ($value, $format) => \Illuminate\Support\Carbon::parse($value)->locale('id')->translatedFormat($format);
@endphp

{{-- DATA PLACEHOLDER (apus kl udh ada data asli) --}}
@php
    $d = fn ($n) => now()->startOfDay()->addDays($n);

    $events = collect([
        ['id' => 1, 'title' => 'Seminar Nasional Teknologi Informasi', 'organization' => (object) ['name' => 'BEM FIK'],            'category' => 'seminar',  'event_date' => $d(3),  'registration_deadline' => $d(1)],
        ['id' => 2, 'title' => 'Lomba UI/UX Mahasiswa',                'organization' => (object) ['name' => 'HIMA SI'],            'category' => 'lomba',    'event_date' => $d(3),  'registration_deadline' => $d(1)],
        ['id' => 3, 'title' => 'Workshop Dasar Laravel',               'organization' => (object) ['name' => 'UKM Programming'],     'category' => 'seminar',  'event_date' => $d(7),  'registration_deadline' => $d(4)],
        ['id' => 4, 'title' => 'Kompetisi Esai Kebangsaan',            'organization' => (object) ['name' => 'BEM UPNVJ'],           'category' => 'lomba',    'event_date' => $d(10), 'registration_deadline' => $d(6)],
        ['id' => 5, 'title' => 'Pelatihan Public Speaking',            'organization' => (object) ['name' => 'KSM Debat'],           'category' => 'seminar',  'event_date' => $d(10), 'registration_deadline' => $d(7)],
        ['id' => 6, 'title' => 'Beasiswa Prestasi Semester Genap',     'organization' => (object) ['name' => 'Biro Kemahasiswaan'],  'category' => 'beasiswa', 'event_date' => $d(10), 'registration_deadline' => $d(8)],
        ['id' => 7, 'title' => 'Lomba Debat Antar Fakultas',           'organization' => (object) ['name' => 'KSM Debat'],           'category' => 'lomba',    'event_date' => $d(14), 'registration_deadline' => $d(10)],
        ['id' => 8, 'title' => 'Webinar Karier Digital',               'organization' => (object) ['name' => 'BEM FIK'],            'category' => 'seminar',  'event_date' => $d(21), 'registration_deadline' => $d(18)],
    ])->map(fn ($e) => (object) $e);

    // Filter placeholder (nanti dikerjakan controller; pastikan juga daftar pilihannya dikirim dari sana)
    $month        = request('bulan');
    $category     = request('category');
    $organization = request('organization');

    $allEvents = $events;

    $monthOptions = $allEvents
        ->map(fn ($e) => \Illuminate\Support\Carbon::parse($e->event_date)->format('Y-m'))
        ->unique()->sort()->values();

    $organizationOptions = $allEvents
        ->map(fn ($e) => $e->organization->name)
        ->unique()->sort()->values();

    $events = $events
        ->when($month, fn ($c) => $c->filter(fn ($e) => \Illuminate\Support\Carbon::parse($e->event_date)->format('Y-m') === $month))
        ->when($category, fn ($c) => $c->where('category', $category))
        ->when($organization, fn ($c) => $c->filter(fn ($e) => $e->organization->name === $organization))
        ->values();
@endphp

@php
    // pengelompokkan sementara
    $grouped = $events
        ->sortBy('event_date')
        ->groupBy(fn ($e) => \Illuminate\Support\Carbon::parse($e->event_date)->toDateString());

    // PAGINATION PLACEHOLDER: dipotong per kelompok tanggal (placeholder 2 tanggal/halaman; di controller pakai 10)
    $perPage = 10;
    $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();

    $pagedGroups = (new \Illuminate\Pagination\LengthAwarePaginator(
        $grouped->forPage($page, $perPage),
        $grouped->count(),
        $perPage,
        $page,
        ['path' => request()->url()]
    ))->withQueryString();

    $hasFilter = $month || $category || $organization;
    $row = 0;
@endphp

<main class="mx-auto max-w-6xl px-6 py-8">

    <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-800 sm:text-4xl">Jadwal Event</h1>
            <p class="mt-2 text-slate-500">Seluruh event diurutkan berdasarkan tanggal pelaksanaan.</p>
        </div>

        {{-- FILTER --}}
        @php
            $select = 'w-full appearance-none rounded-lg border border-slate-200 bg-white py-2 pl-3 pr-9 text-sm text-slate-700 transition focus:border-karsa-600 focus:outline-none';

            $chevron = '<svg xmlns="http://www.w3.org/2000/svg" class="pointer-events-none absolute right-3 top-1/2 size-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>';
        @endphp

        <form method="GET" action="{{ route('events.schedule') }}" class="flex flex-wrap items-end gap-2">
            {{-- Filter Bulan --}}
            <div class="relative w-40">
                <select id="bulan" name="bulan" onchange="this.form.submit()" class="{{ $select }}">
                    <option value="">Semua bulan</option>
                    @foreach ($monthOptions as $m)
                        <option value="{{ $m }}" @selected($month === $m)>
                            {{ $tgl($m . '-01', 'F Y') }}
                        </option>
                    @endforeach
                </select>
                {!! $chevron !!}
            </div>

            {{-- Filter Kategori --}}
            <div class="relative w-44">
                <select id="category" name="category" onchange="this.form.submit()" class="{{ $select }}">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $key => $label)
                        <option value="{{ $key }}" @selected($category === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                {!! $chevron !!}
            </div>

            {{-- Filter Penyelenggara --}}
            <div class="relative w-52">
                <select id="organization" name="organization" onchange="this.form.submit()" class="{{ $select }}">
                    <option value="">Semua penyelenggara</option>
                    @foreach ($organizationOptions as $name)
                        <option value="{{ $name }}" @selected($organization === $name)>{{ $name }}</option>
                    @endforeach
                </select>
                {!! $chevron !!}
            </div>

            {{-- Reset --}}
            @if ($hasFilter)
                <a href="{{ route('events.schedule') }}"
                class="rounded-lg px-3 py-2 text-sm font-medium text-karsa-700 transition hover:bg-karsa-50">
                    Reset
                </a>
            @endif
        </form>
    </div>

    @if ($events->isEmpty())
        <div class="mt-8 rounded-3xl border-2 border-dashed border-slate-300 bg-white px-6 py-16 text-center">
            <p class="text-lg font-semibold text-slate-800">
                {{ $hasFilter ? 'Tidak ada event yang sesuai filter' : 'Belum ada jadwal event' }}
            </p>
            <p class="mt-1 text-sm text-slate-500">
                {{ $hasFilter ? 'Coba ubah atau reset filter.' : 'Cek lagi nanti, jadwal akan muncul setelah ada event.' }}
            </p>
        </div>
    @else
        <div class="mt-8 overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="w-full min-w-[56rem] border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-slate-100 text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <th class="w-44 px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Event</th>
                        <th class="px-5 py-3">Penyelenggara</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Deadline Pendaftaran</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pagedGroups as $date => $items)
                        @foreach ($items as $event)
                            <tr class="border-t border-slate-200 transition hover:bg-karsa-50/60 {{ $row % 2 === 0 ? 'bg-white' : 'bg-slate-50' }}">

                                {{-- Tanggal digabung (rowspan) untuk event di hari yang sama --}}
                                @if ($loop->first)
                                    <td rowspan="{{ $items->count() }}"
                                        class="border-r border-slate-200 bg-white px-5 py-4 align-top">
                                        <p class="font-semibold text-karsa-600">{{ $tgl($date, 'j F Y') }}</p>
                                        <p class="mt-0.5 text-karsa-600">{{ $tgl($date, 'l') }}</p>
                                    </td>
                                @endif

                                <td class="px-5 py-4 font-semibold text-slate-800">
                                    <a href="{{ route('events.show', $event->id) }}" class="transition hover:text-karsa-700 hover:underline">
                                        {{ $event->title }}
                                    </a>
                                </td>

                                <td class="px-5 py-4 text-slate-600">{{ $event->organization->name ?? '-' }}</td>

                                <td class="px-5 py-4 text-slate-600">{{ $categories[$event->category] ?? 'Lainnya' }}</td>

                                <td class="px-5 py-4 text-slate-600">{{ $tgl($event->registration_deadline, 'j F Y') }}</td>
                            </tr>
                            @php $row++; @endphp
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex flex-col items-center gap-3">
        {{ $pagedGroups->links('partials.pagination') }}
        <p class="text-xs text-slate-500">
            Menampilkan tanggal {{ $pagedGroups->firstItem() }} sampai {{ $pagedGroups->lastItem() }} dari {{ $pagedGroups->total() }} tanggal
        </p>
        </div>
    @endif
</main>
@endsection