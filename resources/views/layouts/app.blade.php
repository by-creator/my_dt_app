<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="pusher-key" content="{{ config('broadcasting.connections.pusher.key') }}">
    <meta name="pusher-cluster" content="{{ config('broadcasting.connections.pusher.options.cluster') }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>GFA | File d'attente</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    @if (request()->routeIs('gfa.tickets-detail') || request()->routeIs('agents.*') || request()->routeIs('services.*'))
        @include('partials.gfa.navbar-style')
        @include('partials.gfa.navbar')
    @endif

    <nav class="navbar navbar-dark bg-dark px-3">
        <span class="navbar-brand">Gestion File d'Attente</span>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    @vite(['resources/js/pusher.js'])
    @stack('scripts')

</body>
</html>
