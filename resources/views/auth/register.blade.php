@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Créer un compte</h2>
            <p class="mt-2 text-gray-600">Rejoignez notre plateforme académique</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name">Nom complet</x-input-label>
                    <x-text-input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Jean Dupont"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

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

                <!-- Password Confirmation -->
                <div>
                    <x-input-label for="password_confirmation">Confirmer le mot de passe</x-input-label>
                    <x-text-input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        required
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" />
                </div>

                <!-- Submit Button -->
                <x-primary-button class="w-full justify-center">
                    <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                    Créer mon compte
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

            <!-- Login Link -->
            <p class="mt-6 text-center text-sm text-gray-600">
                Vous avez déjà un compte?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                    Se connecter
                </a>
            </p>
        </div>

        <!-- Footer -->
        <p class="mt-6 text-center text-xs text-gray-500">
            Système de gestion des mémoires universitaires
        </p>
    </div>
</div>
@endsection
