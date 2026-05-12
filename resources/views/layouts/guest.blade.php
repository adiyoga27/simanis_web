<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIMANIS - Aplikasi Manajemen Diabetes Melitus. Pantau gula darah, screening kaki, edukasi, terapi nutrisi, dan manajemen pengobatan.">
    <meta name="keywords" content="simanis, diabetes, gula darah, screening kaki, edukasi diabetes, nutrisi diabetes">
    <meta name="author" content="SIMANIS">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>@yield('title', 'SIMANIS') - SIMANIS</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-pink-50 via-white to-red-50 min-h-screen">
    <div id="app">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
