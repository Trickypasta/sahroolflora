<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SahroolFlora')</title>

    {{-- Google Fonts (Hanya satu blok) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lora:wght@400;700&display=swap"
        rel="stylesheet">
    
    {{-- Menggunakan sintaks Vite terbaru dengan array --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine.js dari CDN (Cara Anda saat ini, ini tidak apa-apa) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white text-gray-800 font-sans">

    @include('partials.navbar')
    @include('partials.notification')

    <main>
        @yield('content')
    </main>

     @include('partials.footer') 

    @stack('scripts')
</body>

</html>
