@extends('layouts.app')

@section('title', 'Detail Event')

@section('content')

@php
    // DATA PLACEHOLDER (hapus kalau sudah menggunakan data asli)
    $event = (object) [
        'id'                    => 1,
        'title'                 => 'Seminar Nasional Teknologi Informasi',
        'description'           => "Seminar ini membahas perkembangan teknologi informasi terkini dan peluangnya bagi mahasiswa.\n\nPeserta akan mendapatkan materi dari pembicara berpengalaman, sesi tanya jawab, dan sertifikat kehadiran.",
        'organization'          => (object) ['name' => 'BEM FIK'],
        'location'              => 'Aula Gedung Fakultas Ilmu Komputer, UPNVJ',
        'event_date'            => now()->addDays(20),
        'registration_deadline' => now()->addDays(12),
        'registration_url'      => 'https://example.com/daftar',
        'poster_path'           => null,
    ];
@endphp

<main class="mx-auto max-w-6xl px-6 py-8">
    <h1 class="text-2xl font-semibold text-slate-800 sm:text-3xl">{{ $event->title }}</h1>
    <div class="mt-6 grid gap-8 lg:grid-cols-[16rem_minmax(0,1fr)_16rem]">
        {{--POSTER--}}
        <aside class="space-y-3 lg:sticky lg:top-24 lg:self-start">
            <div class="aspect-[3/4] overflow-hidden rounded-2xl border border-slate-200 bg-linear-to-br from-karsa-200 to-accent-200 shadow-sm">
                @if ($event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}"
                         alt="Poster {{ $event->title }}"
                         class="size-full object-cover">
                @else
                    <div class="flex size-full items-center justify-center text-karsa-500/60">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <circle cx="9" cy="10" r="1.8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m3 17 5-4.5 4 3.5 3-2.5 6 5"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Button Preview --}}
            <button type="button" id="open-poster"
                    class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-karsa-600 hover:bg-karsa-50 hover:text-karsa-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                Lihat Poster
            </button>

            {{-- Button Download --}}
            <a href="{{ route('events.poster', $event->id) }}"
               class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-karsa-600 hover:bg-karsa-50 hover:text-karsa-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v11m0 0-4-4m4 4 4-4M5 20h14"/>
                </svg>
                Unduh Poster
            </a>
        </aside>

        {{--INFORMASI--}}
        <section class="min-w-0">
            <h2 class="text-xl font-semibold text-slate-800">Informasi Event</h2>

            <dl class="mt-3 divide-y divide-slate-200 border-y border-slate-200 text-sm">
                <div class="grid grid-cols-[9rem_1fr] gap-4 py-3">
                    <dt class="text-slate-500">Penyelenggara</dt>
                    <dd class="font-medium text-slate-800">{{ $event->organization->name ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-[9rem_1fr] gap-4 py-3">
                    <dt class="text-slate-500">Lokasi</dt>
                    <dd class="font-medium text-slate-800">{{ $event->location }}</dd>
                </div>
                <div class="grid grid-cols-[9rem_1fr] gap-4 py-3">
                    <dt class="text-slate-500">Tanggal</dt>
                    <dd class="font-medium text-slate-800">
                        {{ \Illuminate\Support\Carbon::parse($event->event_date)->translatedFormat('l, j F Y') }}
                    </dd>
                </div>
                <div class="grid grid-cols-[9rem_1fr] gap-4 py-3">
                    <dt class="text-slate-500">Deadline Pendaftaran</dt>
                    <dd class="font-medium text-slate-800">
                        {{ \Illuminate\Support\Carbon::parse($event->registration_deadline)->translatedFormat('l, j F Y') }}
                    </dd>
                </div>
            </dl>

            {{-- Deskripsi --}}
            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="border-l-4 border-karsa-600 pl-3 text-lg font-semibold text-slate-800">Deskripsi</h3>
                <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $event->description }}</p>
            </div>
        </section>

        {{--PENDAFTARAN--}}
        <aside class="lg:self-start">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-800">Pendaftaran</h3>
                <p class="mt-2 text-sm text-slate-500">
                    Pendaftaran dilakukan melalui tautan milik penyelenggara. Karsa tidak memproses pendaftaran.
                </p>

                <a href="{{ $event->registration_url }}" target="_blank" rel="noopener noreferrer"
                   class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl bg-karsa-700 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-karsa-500/40 transition hover:bg-karsa-800">
                    Daftar Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M9 7h8v8"/>
                    </svg>
                </a>
            </div>
        </aside>
    </div>
</main>

{{--POP-UP PRATINJAU POSTER--}}
<dialog id="poster-dialog"
        class="m-auto w-[90vw] max-w-lg rounded-2xl p-0 shadow-2xl backdrop:bg-slate-900/60 backdrop:backdrop-blur-sm">
    <div class="p-3">
        <div class="flex justify-end pb-2">
            <button type="button" id="close-poster" aria-label="Tutup"
                    class="flex size-8 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6 6 18"/>
                </svg>
            </button>
        </div>

        @if ($event->poster_path)
            <img src="{{ asset('storage/' . $event->poster_path) }}"
                 alt="Poster {{ $event->title }}"
                 class="max-h-[75vh] w-full rounded-xl object-contain">
        @else
            <div class="flex aspect-[3/4] w-full items-center justify-center rounded-xl bg-linear-to-br from-karsa-200 to-accent-200 text-sm text-karsa-700/70">
                Poster belum tersedia
            </div>
        @endif
    </div>
</dialog>
@endsection