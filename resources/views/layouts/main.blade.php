<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Durabequipe-backend</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Icons -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    @livewireStyles
</head>
<body>

<script>
    document.documentElement.classList.remove('dark');
    localStorage.setItem('color-theme', 'light');
</script>

@yield('scripts')

<div class="" style="width: 100vw; height: 100vh;">
    @yield('content')
</div>

<x-tall-interactive::actionables-manager/>


@stack('modals')

@livewireScripts

@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

@if (session()->has('success'))
    <script>
        var notyf = new Notyf({dismissible: true})
        notyf.success('{{ session('success') }}')
    </script>
@endif

</body>
</html>
