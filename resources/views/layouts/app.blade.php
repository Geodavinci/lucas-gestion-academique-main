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
    <body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col transition-colors duration-200">
        @include('layouts.navigation')

        <!-- Toast Container -->
        <x-toast />

        <!-- Confirmation Modal -->
        <x-confirm-modal />

        <!-- Batch Confirmation Modal -->
        <x-batch-confirm-modal />

        <main class="max-w-6xl mx-auto w-full px-6 py-8 flex-1">
            @yield('content')
        </main>

        @stack('scripts')

        <!-- Show Toasts from Session -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    document.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            id: Math.random(),
                            type: 'success',
                            title: 'Succès',
                            message: '{{ session('success') }}',
                            duration: 4000
                        }
                    }));
                @endif

                @if (session('error'))
                    document.dispatchEvent(new CustomEvent('notify', {
                        detail: {
                            id: Math.random(),
                            type: 'error',
                            title: 'Erreur',
                            message: '{{ session('error') }}',
                            duration: 5000
                        }
                    }));
                @endif

                @if ($errors->any())
                    const errorMessages = [
                        @foreach ($errors->all() as $error)
                            '{{ $error }}',
                        @endforeach
                    ];

                    errorMessages.forEach(msg => {
                        document.dispatchEvent(new CustomEvent('notify', {
                            detail: {
                                id: Math.random(),
                                type: 'error',
                                title: 'Validation',
                                message: msg,
                                duration: 5000
                            }
                        }));
                    });
                @endif
            });
        </script>
    </body>
</html>
