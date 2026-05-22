@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Bienvenue</h2>
            <p class="mt-2 text-gray-600">Connectez-vous à votre compte</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email">Adresse email</x-input-label>
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="votre@email.com"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password">Mot de passe</x-input-label>
                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                    />
                    <x-input-error :messages="$errors->get('password')" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="w-4 h-4 border-gray-300 rounded text-blue-600 focus:ring-blue-500"
                    >
                    <label for="remember" class="text-sm text-gray-600">Se souvenir de moi</label>
                </div>

                <!-- Submit Button -->
                <x-primary-button class="w-full justify-center">
                    <x-icon name="check" size="sm" class="w-4 h-4" />
                    Se connecter
                </x-primary-button>
            </form>

            <!-- Divider -->
            <div class="mt-6 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Ou</span>
                </div>
            </div>

            <!-- Register Link -->
            <p class="mt-6 text-center text-sm text-gray-600">
                Pas encore de compte?
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                    S'inscrire
                </a>
            </p>

            @if (Route::has('password.request'))
                <p class="mt-4 text-center text-sm">
                    <a href="{{ route('password.request') }}" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                        Mot de passe oublié?
                    </a>
                </p>
            @endif
        </div>

        <!-- Footer -->
        <p class="mt-6 text-center text-xs text-gray-500">
            Système de gestion des mémoires universitaires
        </p>
    </div>
</div>
@endsection
