<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Event - Karsa</title>
</head>
<body>
    <h1>Kelola Event</h1>
    <p>Login sebagai: {{ auth()->user()->name }}</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.events.create') }}" class="btn">+ Tambah Event</a>

    @if ($events->isEmpty())
        <p>Belum ada event. Tambahkan event pertama organisasimu.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Organisasi</th>
                    <th>Kategori</th>
                    <th>Tanggal Acara</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr>
                        <td>{{ $events->firstItem() + $loop->index }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->organization->name }}</td>
                        <td>{{ $categories[$event->category] ?? $event->category }}</td>
                        <td>{{ $event->event_date->format('d M Y') }}</td>
                        <td>{{ $event->registration_deadline->format('d M Y') }}</td>
                        <td>
                            @switch($event->statusPendaftaran())
                                @case('open')
                                    <span class="badge badge-open">Open</span>
                                    @break
                                @case('closing')
                                    <span class="badge badge-closing">Segera Ditutup</span>
                                    @break
                                @default
                                    <span class="badge badge-closed">Closed</span>
                            @endswitch
                        </td>
                        <td>
                            <td>
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn">Ubah</a>

                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="form-hapus"
                                    data-pesan="Hapus event &quot;{{ $event->title }}&quot;? Data dan posternya tidak bisa dikembalikan."
                                    onsubmit="return confirm(this.dataset.pesan)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $events->links('pagination::default') }}
    @endif
</body>
</html>