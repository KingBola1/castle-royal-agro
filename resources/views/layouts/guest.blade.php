<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Castle Royal Agro') }}</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="font-sans text-gray-900 antialiased relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        {{-- The Golden Green Background Pattern --}}
        <div class="absolute inset-0 z-0 bg-repeat bg-[length:400px_400px] opacity-60" style="background-image: url('{{ asset('images/backgrounds/moringa_pattern.png') }}');"></div>
        <div class="absolute inset-0 z-0 bg-gradient-to-b from-transparent to-green-900/10"></div>

        <div class="relative z-10">
            <a href="/">
                <x-application-logo class="w-24 h-24 fill-current text-gray-500 shadow-xl rounded-lg" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-xl relative z-10 border-t-4 border-yellow-500">
            {{ $slot }}
        </div>
        
    </body>
</html>