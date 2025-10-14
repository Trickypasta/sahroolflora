<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings['general_sitename'] ?? 'SahroolFlora')</title>
    <link rel="icon"
        href="{{ isset($settings['general_favicon']) ? asset('storage/' . $settings['general_favicon']) : asset('favicon.ico') }}"
        type="image/x-icon">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lora:wght@400;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>


<body class="bg-white text-gray-800 font-sans antialiased">

    @include('partials.navbar')
    @include('partials.notification')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800, 
            once: true, 
        });
    </script>
    @stack('scripts')
</body>

</html>
