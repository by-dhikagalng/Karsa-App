<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Event - Karsa</title>
</head>
<body>
    <h1>Tambah Event</h1>

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" id="form-event">
        @csrf

        @include('admin.events._form')

        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('admin.events.index') }}" class="btn">Batal</a>
    </form>
</body>
</html>