@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Enseignants', 'url' => route('teachers.index')],
    ['label' => 'Ajouter un enseignant']
]" />

<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-violet-600 via-purple-500 to-pink-500 bg-clip-text text-transparent">Ajouter un enseignant</h1>
        <p class="mt-2 text-gray-600 text-lg">Remplissez les informations ci-dessous</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
        <form method="POST" action="{{ route('teachers.store') }}" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom -->
                <div>
                    <x-input-label for="nom" class="text-sm font-semibold text-gray-700">Nom *</x-input-label>
                    <x-text-input
                        id="nom"
                        name="nom"
                        type="text"
                        value="{{ old('nom') }}"
                        placeholder="Ex: Dupont"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                    />
                    <x-input-error :messages="$errors->get('nom')" />
                </div>

                <!-- Prénom -->
                <div>
                    <x-input-label for="prenom" class="text-sm font-semibold text-gray-700">Prénom *</x-input-label>
                    <x-text-input
                        id="prenom"
                        name="prenom"
                        type="text"
                        value="{{ old('prenom') }}"
                        placeholder="Ex: Jean"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                    />
                    <x-input-error :messages="$errors->get('prenom')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" class="text-sm font-semibold text-gray-700">Email *</x-input-label>
                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="Ex: jean@email.com"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                    />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Téléphone -->
                <div>
                    <x-input-label for="telephone" class="text-sm font-semibold text-gray-700">Téléphone</x-input-label>
                    <x-text-input
                        id="telephone"
                        name="telephone"
                        type="text"
                        value="{{ old('telephone') }}"
                        placeholder="Ex: +221 77 123 45 67"
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                    />
                    <x-input-error :messages="$errors->get('telephone')" />
                </div>

                <!-- Spécialité -->
                <div class="md:col-span-2">
                    <x-input-label for="specialite" class="text-sm font-semibold text-gray-700">Spécialité *</x-input-label>
                    <x-text-input
                        id="specialite"
                        name="specialite"
                        type="text"
                        value="{{ old('specialite') }}"
                        placeholder="Ex: Informatique, Mathématiques, etc."
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                    />
                    <x-input-error :messages="$errors->get('specialite')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200 flex gap-3 justify-end">
                <a href="{{ route('teachers.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-violet-600 to-purple-700 text-white hover:shadow-lg hover:from-violet-700 hover:to-purple-800 active:scale-95 transition-all duration-200 font-semibold">
                    <x-icon name="check" size="sm" class="w-4 h-4" />
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
