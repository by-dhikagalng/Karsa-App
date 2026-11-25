<h1>TODO Detail Event Nasywa</h1>
<p>{{ $event->title }} oleh {{ $event->organization->name }}, status: {{ $event->statusPendaftaran() }}</p>

@if ($event->poster_path)
    <p>
        <a href="{{ route('events.poster', $event) }}" class="btn">Unduh Poster</a>
    </p>
@else
    <p><em>Poster belum tersedia.</em></p>
@endif