<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-white to-cyan-50">
            <div class="text-center mb-8">
                <a href="/" class="inline-flex flex-col items-center gap-3 hover:opacity-80 transition-opacity">
                    <div class="bg-gradient-to-br from-blue-100 to-cyan-100 rounded-xl p-4 shadow-lg">
                        <x-application-logo class="w-16 h-16 fill-current text-blue-600" />
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Lucas</p>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Gestion Académique</h1>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-lg rounded-2xl border border-gray-100/50 overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
