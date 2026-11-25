
<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur-md">
    <nav class="relative mx-auto flex max-w-6xl items-center justify-between px-6 py-4">

        <a href="{{ route('events.index') }}"
           class="shrink-0 text-2xl font-bold tracking-tight text-karsa-700">
            Karsa
        </a>

        <div class="absolute left-1/2 hidden -translate-x-1/2 items-center gap-2 text-sm font-medium md:flex">
            <a href="{{ route('events.index') }}"
               class="rounded-lg px-3 py-2 transition
               {{ request()->routeIs('events.index', 'events.show')
                    ? 'font-bold text-karsa-700'
                    : 'text-slate-500 hover:bg-slate-100' }}">
                Katalog Event
            </a>

            <a href="{{ route('events.schedule') }}"
               class="rounded-lg px-3 py-2 transition
               {{ request()->routeIs('events.schedule')
                    ? 'font-bold text-karsa-700'
                    : 'text-slate-500 hover:bg-slate-100' }}">
                Jadwal
            </a>
        </div>

        <div class="ml-auto flex items-center gap-3">
            <form method="GET" action="{{ route('events.index') }}"
                  class="relative hidden w-48 lg:block xl:w-56">

                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="pointer-events-none absolute left-3.5 top-1/2 size-4 -translate-y-1/2 text-slate-400"
                     fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20 20-3.5-3.5"/>
                </svg>

                <input type="search" name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari event..."
                       class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-10 pr-3 text-sm text-slate-800 placeholder:text-slate-400 transition focus:border-karsa-700 focus:bg-white focus:outline-none">
            </form>

            <a href="{{ route('login') }}"
               class="shrink-0 rounded-xl bg-karsa-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-karsa-800">
                Admin Login
            </a>
        </div>
    </nav>
</header>
