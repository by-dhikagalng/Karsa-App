@if ($paginator->hasPages())
    @php
        $box    = 'flex size-9 items-center justify-center rounded-lg border text-sm transition';
        $idle   = 'border-slate-200 bg-white text-slate-600 hover:border-karsa-600 hover:bg-karsa-50 hover:text-karsa-700';
        $off    = 'border-slate-200 bg-white text-slate-300';
        $active = 'border-karsa-600 bg-karsa-700 font-semibold text-white shadow-lg shadow-karsa-500/40';
    @endphp

    <nav class="flex items-center justify-center gap-1" aria-label="Pagination">
        {{-- Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="{{ $box }} {{ $off }}">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $box }} {{ $idle }}">&lsaquo;</a>
        @endif

        {{-- Nomor halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-1 text-slate-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="{{ $box }} {{ $active }}">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="{{ $box }} {{ $idle }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Berikutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $box }} {{ $idle }}">&rsaquo;</a>
        @else
            <span class="{{ $box }} {{ $off }}">&rsaquo;</span>
        @endif
    </nav>
@endif