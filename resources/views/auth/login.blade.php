{{-- VIEW DUMMY SEMENTARA untuk testing fitur Authentication di branch feature/auth.
     Sesuai arahan Ketua, file ini akan dihapus/disesuaikan dengan UI login buatan Nasywa saat merge. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Karsa App (Dummy)</title>
</head>
<body>
    <main style="max-width: 400px; margin: 60px auto; font-family: sans-serif;">
        <h1>Login Admin Karsa App</h1>
        <p style="color: #555; font-size: 14px;">
            (View dummy sementara untuk uji Authentication &amp; Role)
        </p>

        @if (session('success'))
            <div style="padding: 10px; background: #e6ffed; color: #1b5e20; margin-bottom: 16px; border-radius: 6px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="padding: 10px; background: #ffebee; color: #c62828; margin-bottom: 16px; border-radius: 6px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div style="margin-bottom: 12px;">
                <label for="email">Email</label><br>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="nama@karsa.test" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 16px;">
                <label for="password">Password</label><br>
                <input id="password" type="password" name="password" required
                       placeholder="Masukkan password" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <button type="submit" style="width: 100%; padding: 10px; cursor: pointer;">
                Login
            </button>
        </form>

        <p style="margin-top: 16px;">
            <a href="{{ route('events.index') }}">Kembali ke Katalog Event</a>
        </p>
    </main>
</body>
</html>