<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Event - Karsa</title>
</head>
<body>
    <h1>Ubah Event</h1>

    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" id="form-event">
        @csrf
        @method('PUT')

        @if ($event->poster_path)
            <div class="form-group">
                <p>Poster saat ini:</p>
                <img src="{{ asset($event->poster_path) }}" alt="Poster {{ $event->title }}" width="200">
                <p>Unggah poster baru di bawah jika ingin menggantinya.</p>
            </div>
        @endif

        @include('admin.events._form')

        <button type="submit" class="btn">Simpan Perubahan</button>
        <a href="{{ route('admin.events.index') }}" class="btn">Batal</a>
    </form>
</body>
</html>