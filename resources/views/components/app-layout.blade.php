<!-- layout untuk landing page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="/favicon.png" sizes="any">
    <link rel="icon" href="/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="/favicon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>

<body class="min-h-screen bg-neutral-900 text-white font-sans selection:bg-indigo-500/30 selection:text-indigo-200">
    <!-- Navbar -->
    <x-user.header />
    {{ $slot }}
    <!-- Footer -->
    <x-user.footer />
    @livewireScripts
    @fluxScripts
</body>

</html>