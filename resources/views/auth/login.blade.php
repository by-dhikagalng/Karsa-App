@extends('layouts.app')

@section('title', 'Login')
@section('hide-header', true)

@section('content')
<div class="min-h-screen bg-white">
    <div class="grid min-h-screen w-full p-3 lg:grid-cols-2">
        <div class="relative hidden min-h-[640px] flex-col justify-between overflow-hidden rounded-3xl bg-linear-to-br from-karsa-600 via-karsa-700 to-accent-700 p-10 text-white lg:flex">
            <a href="{{ route('events.index') }}" class="relative text-2xl font-bold tracking-tight">Karsa</a>
            <div class="pointer-events-none absolute -right-24 top-1/4 size-[30rem] rounded-full bg-karsa-400/50 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-16 -top-16 size-64 rounded-full bg-karsa-300/30 blur-3xl"></div>

            <img src="{{ asset('images/charm_north-star.png') }}"
                 alt=""
                 aria-hidden="true"
                 class="pointer-events-none absolute -bottom-16 -right-28 h-[28rem] w-auto object-contain opacity-15">

            <img src="{{ asset('images/charm_north-star.png') }}"
                 alt=""
                 aria-hidden="true"
                 class="pointer-events-none absolute left-8 top-24 h-20 w-20 object-contain opacity-15">

            <div class="relative z-10">
                <h2 class="mt-4 text-5xl font-semibold leading-tight">Kelola kegiatan organisasimu</h2>
                <p class="mt-3 text-white/80">Masuk untuk mengatur event, poster, dan jadwal organisasimu.</p>

                <div class="mt-8 grid grid-cols-3 gap-3">
                    <div class="flex min-h-36 flex-col justify-between rounded-2xl border border-white/30 bg-white/20 p-4 text-white shadow-lg backdrop-blur-md">
                        <span class="flex size-7 items-center justify-center rounded-full bg-white text-sm text-accent-700">1</span>
                        <p class="text-sm font-medium">Masuk ke akun admin</p>
                    </div>
                    <div class="flex min-h-36 flex-col justify-between rounded-2xl border border-white/30 bg-white/20 p-4 text-white shadow-lg backdrop-blur-md">
                        <span class="flex size-7 items-center justify-center rounded-full bg-white text-sm text-accent-700">2</span>
                        <p class="text-sm font-medium">Kelola event dan jadwal</p>
                    </div>
                    <div class="flex min-h-36 flex-col justify-between rounded-2xl border border-white/30 bg-white/20 p-4 text-white shadow-lg backdrop-blur-md">
                        <span class="flex size-7 items-center justify-center rounded-full bg-white text-sm text-accent-700">3</span>
                        <p class="text-sm font-medium">Unggah poster kegiatan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center px-6 py-12 sm:px-12">
            <form method="POST" action="{{ route('login.store') }}" class="w-full max-w-sm">
                @csrf

                <a href="{{ route('events.index') }}" class="mb-6 block text-center text-xl font-bold text-karsa-700 lg:hidden">Karsa</a>
                <h1 class="mb-4text-left text-3xl font-semibold text-neutral-900">Selamat datang, Admin!</h1>
                <h2 class="mb-8 text-left text-sm text-neutral-500">Siap bagikan kegiatan seru?</h2>

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="mb-2 block text-sm font-semibold text-neutral-900">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                           placeholder="nama@email.com"
                           class="w-full rounded-xl border-2 border-transparent bg-neutral-100 px-4 py-3.5 text-sm placeholder:text-neutral-400 focus:border-karsa-600 focus:bg-white focus:outline-none">
                </div>

                {{-- Password --}}
                <div class="mb-5">
                    <label for="password" class="mb-2 block text-sm font-semibold text-neutral-900">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                               placeholder="Masukkan password"
                               class="w-full rounded-xl border-2 border-transparent bg-neutral-100 px-4 py-3.5 text-sm placeholder:text-neutral-400 focus:border-karsa-600 focus:bg-white focus:outline-none">
                        <button type="button" id="toggle-password" aria-label="Tampilkan password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                @if ($errors->any())
                    <p class="mb-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600">{{ $errors->first() }}</p>
                @endif

                <button type="submit"
                        class="w-full rounded-xl bg-karsa-700 py-3.5 font-semibold text-white shadow-lg shadow-karsa-500/50 transition hover:bg-karsa-800">
                    Lanjutkan
                </button>

                <p class="mt-4 text-center text-sm text-neutral-500">
                    Hanya untuk admin organisasi dan superadmin.
                    <br>
                    <a href="{{ route('events.index') }}" class="font-medium text-karsa-700 hover:underline">Kembali ke katalog</a>
                </p>
            </form>
        </div>
    </div>
</div>

@endsection