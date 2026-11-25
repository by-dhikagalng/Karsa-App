<!DOCTYPE html>
<html lang="id" class="[scrollbar-gutter:stable]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Karsa App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="{{ request()->routeIs('events.index', 'events.show', 'events.schedule') ? 'bg-slate-50' : '' }}">
    @hasSection('hide-header')
    @else
        @include('partials.header')
    @endif

    @yield('content')
</body>

</html>