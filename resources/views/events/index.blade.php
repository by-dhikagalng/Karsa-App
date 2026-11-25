@extends('layouts.app')

@section('title', 'Katalog Event')

@section('content')

@php
    // Status otomatis dari registration_deadline:
    // ditutup, segera ditutup, atau dibuka.
    $statusOf = function ($deadline) {
        $deadline = \Illuminate\Support\Carbon::parse($deadline)->startOfDay();
        $today = now()->startOfDay();

        if ($deadline->lt($today)) return 'closed';
        if ($deadline->lte($today->copy()->addDays(3))) return 'soon';

        return 'open';
    };

    $badges = [
        'open'   => ['Dibuka',         'border-emerald-300 bg-emerald-100/80 text-emerald-700'],
        'soon'   => ['Segera Ditutup', 'border-amber-300 bg-amber-100/80 text-amber-700'],
        'closed' => ['Ditutup',        'border-red-300 bg-red-100/80 text-red-700'],
    ];

    $activeCategory = request('category');
    $search = trim((string) request('q'));
@endphp

{{-- HERO --}}
<section class="relative overflow-hidden rounded-b-[1.5rem] bg-linear-to-br from-karsa-600 via-karsa-700 to-accent-700 text-white md:h-[34rem] lg:h-[38rem]">
    <div class="pointer-events-none absolute -right-24 top-1/4 size-[36rem] rounded-full bg-karsa-400/50 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-16 -top-16 size-72 rounded-full bg-karsa-300/30 blur-3xl"></div>

    {{-- Dekorasi bintang --}}
    <img src="{{ asset('images/charm_north-star.png') }}"
         alt=""
         aria-hidden="true"
         class="pointer-events-none absolute -right-[15%] top-0 hidden h-full w-auto object-contain opacity-15 sm:block">

    <img src="{{ asset('images/charm_north-star.png') }}"
         alt=""
         aria-hidden="true"
         class="pointer-events-none absolute -bottom-[8%] -left-[8%] h-[45%] w-auto object-contain opacity-25">

    <div class="relative z-10 flex h-full max-w-3xl flex-col justify-center px-8 pb-24 pt-12 sm:px-12 md:pt-8 lg:px-16">
        <h1 class="text-3xl font-semibold leading-tight sm:text-4xl lg:text-5xl">
            Temukan Kegiatan Kampus yang Cocok Untukmu!
        </h1>

        <p class="mt-5 max-w-xl text-lg text-white/90 lg:text-xl">
            Seminar, lomba, beasiswa, dan lainnya, semua terkumpul dalam satu tempat.
        </p>

        <a href="#daftar-event"
           class="mt-7 inline-flex w-fit items-center justify-center rounded-xl bg-white px-5 py-3.5 font-semibold text-karsa-700 shadow-lg shadow-karsa-500/50 transition hover:bg-karsa-50">
            Temukan Acaramu
        </a>
    </div>

    <img src="{{ asset('images/ilustrasi.png') }}"
         alt="Ilustrasi Mahasiswa"
         class="mx-auto h-72 object-contain object-bottom md:pointer-events-none md:absolute md:bottom-0 md:right-16 md:mx-0 md:h-[108%] md:max-w-[55%] lg:right-24">
</section>

{{-- CONTAINER PALING LUAR --}}
<main class="relative z-10 mx-auto -mt-16 max-w-[75rem] px-4 md:-mt-24">
    <div class="bg-slate-50 px-6 pb-12 pt-8 sm:px-8 md:rounded-t-[1rem] md:pt-10">

        <section id="daftar-event">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                {{-- Judul --}}
                <div>
                    <h2 class="text-2xl font-semibold text-slate-800">
                        Jelajahi Event
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Temukan event sesuai minatmu.
                    </p>
                </div>

                {{-- Filter Kategori --}}
                @php
                    $tab = 'whitespace-nowrap rounded-lg border px-4 py-2 text-sm transition';
                @endphp

                <nav class="flex gap-2 overflow-x-auto pb-1"
                     aria-label="Filter kategori">

                    <a href="{{ route('events.index', array_filter(['q' => $search])) }}"
                       class="{{ $tab }} {{ ! $activeCategory
                            ? 'border-karsa-700 bg-karsa-700 font-semibold text-white'
                            : 'border-slate-200 bg-white text-slate-600 hover:border-karsa-700 hover:bg-karsa-50 hover:text-karsa-700' }}">
                        Semua
                    </a>

                    @foreach ($categories as $key => $label)
                        <a href="{{ route('events.index', array_filter(['category' => $key, 'q' => $search])) }}"
                           class="{{ $tab }} {{ $activeCategory === $key
                                ? 'border-karsa-700 bg-karsa-700 font-semibold text-white'
                                : 'border-slate-200 bg-white text-slate-600 hover:border-karsa-700 hover:bg-karsa-50 hover:text-karsa-700' }}">
                            {{ $label }}
                        </a>
                    @endforeach

                </nav>
            </div>
        </section>

        {{-- DAFTAR EVENT --}}
        @if ($events->isEmpty())

            {{-- Empty state --}}
            <div class="mt-8 rounded-3xl border-2 border-dashed border-slate-300 bg-white px-6 py-16 text-center">

                <p class="text-lg font-semibold text-slate-800">
                    Belum ada event yang sesuai
                </p>

                <p class="mt-1 text-sm text-slate-500">
                    Coba pilih kategori lain atau cek lagi nanti.
                </p>

                <a href="{{ route('events.index') }}"
                   class="mt-6 inline-block rounded-xl bg-karsa-700 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-karsa-500/40 transition hover:bg-karsa-800">
                    Lihat semua event
                </a>

            </div>

        @else

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($events as $event)

                    @php
                        $status = $statusOf($event->registration_deadline);
                        [$statusLabel, $statusClass] = $badges[$status];
                    @endphp

                    <article class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-3 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">

                        <a href="{{ route('events.show', $event->id) }}"
                           class="flex flex-1 flex-col">

                            {{-- Poster --}}
                            <div class="relative aspect-[4/3] overflow-hidden rounded-xl bg-linear-to-br from-karsa-200 to-accent-200">

                                @if ($event->poster_path)

                                    <img src="{{ asset('storage/' . $event->poster_path) }}"
                                         alt="Poster {{ $event->title }}"
                                         class="size-full object-cover transition duration-300 group-hover:scale-105">

                                @else

                                    <div class="flex size-full items-center justify-center text-karsa-500/60">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="size-12"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.5">

                                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                                            <circle cx="9" cy="10" r="1.8"/>
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="m3 17 5-4.5 4 3.5 3-2.5 6 5"/>

                                        </svg>

                                    </div>

                                @endif

                            </div>

                            {{-- Info --}}
                            <div class="flex flex-1 flex-col px-1 pb-1 pt-4">

                                <div class="flex items-center justify-between gap-2">

                                    <span class="text-xs font-medium text-slate-500">
                                        {{ $categories[$event->category] ?? 'Lainnya' }}
                                    </span>

                                    <span class="whitespace-nowrap rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>

                                </div>

                                <h2 class="mt-1 text-base font-semibold leading-snug text-slate-800">
                                    {{ $event->title }}
                                </h2>

                                <div class="mt-auto space-y-2 pt-4 text-sm text-slate-500">

                                    <p class="flex items-center gap-2">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="size-4 shrink-0"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M4 21V5a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16M14 9h5a1 1 0 0 1 1 1v11M2 21h20M8 8h2M8 12h2M8 16h2"/>

                                        </svg>

                                        {{ $event->organization->name ?? '-' }}

                                    </p>

                                    <p class="flex items-center gap-2">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="size-4 shrink-0"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="1.8">

                                            <rect x="3" y="5" width="18" height="16" rx="2"/>
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M8 3v4M16 3v4M3 10h18"/>

                                        </svg>

                                        {{ \Illuminate\Support\Carbon::parse($event->event_date)->translatedFormat('j F Y') }}

                                    </p>

                                </div>

                            </div>

                        </a>

                    </article>

                @endforeach

            </div>

            {{-- PAGINATION --}}
            <div class="mt-10">
               {{ $events->withQueryString()->links('partials.pagination') }}
            </div>

        @endif

    </div>
</main>

@endsection
