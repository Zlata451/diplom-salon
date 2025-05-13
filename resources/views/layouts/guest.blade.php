<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-DXnCgaXg.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('build/assets/app-Bo-u61x1.js') }}" defer></script>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div class="min-h-screen bg-gray-100">
        {{-- Навігація, якщо потрібна --}}
        @include('layouts.navigation')

        {{-- Заголовок, якщо потрібно --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Контент форми --}}
        <main class="flex justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md bg-white p-8 rounded shadow">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
