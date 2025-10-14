<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SahroolFlora</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lora:wght@400;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-sans antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        <div class="hidden lg:block relative">
            <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('images/auth-background.jpg') }}"
                alt="Tanaman hias di dalam ruangan">
        </div>

        <div class="flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-12">
            <div class="w-full max-w-md">
                {{-- Logo --}}
                <div>
                    <a href="{{ route('home') }}" class="font-lora text-4xl font-bold text-gray-800">
                        SahroolFlora
                    </a>
                </div>
                <div class="mt-8">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>

</html>
