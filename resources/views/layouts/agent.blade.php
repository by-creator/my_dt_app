<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ably-key" content="{{ config('broadcasting.connections.ably.key') }}">
    <title>GFA | Agent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <div class="container-fluid">
        @yield('content')
    </div>

    @stack('scripts')

</body>
</html>
