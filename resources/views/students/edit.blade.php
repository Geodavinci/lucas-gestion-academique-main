@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Étudiants', 'url' => route('students.index')],
    ['label' => $student->nom . ' ' . $student->prenom, 'url' => route('students.show', $student)],
    ['label' => 'Modifier']
]" />

<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 bg-clip-text text-transparent">Modifier l'étudiant</h1>
        <p class="mt-2 text-gray-600 text-lg">Mettez à jour les informations</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
        <form method="POST" action="{{ route('students.update', $student) }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Matricule -->
                <div>
                    <x-input-label for="matricule" class="text-sm font-semibold text-gray-700">Matricule *</x-input-label>
                    <x-text-input
                        id="matricule"
                        name="matricule"
                        type="text"
                        value="{{ old('matricule', $student->matricule) }}"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                    <x-input-error :messages="$errors->get('matricule')" />
                </div>

                <!-- Filière -->
                <div>
                    <x-input-label for="filiere" class="text-sm font-semibold text-gray-700">Filière *</x-input-label>
                    <x-text-input
                        id="filiere"
                        name="filiere"
                        type="text"
                        value="{{ old('filiere', $student->filiere) }}"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                    <x-input-error :messages="$errors->get('filiere')" />
                </div>

                <!-- Nom -->
                <div>
                    <x-input-label for="nom" class="text-sm font-semibold text-gray-700">Nom *</x-input-label>
                    <x-text-input
                        id="nom"
                        name="nom"
                        type="text"
                        value="{{ old('nom', $student->nom) }}"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
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
                        value="{{ old('prenom', $student->prenom) }}"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
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
                        value="{{ old('email', $student->email) }}"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
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
                        value="{{ old('telephone', $student->telephone) }}"
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                    <x-input-error :messages="$errors->get('telephone')" />
                </div>

                <!-- Niveau -->
                <div>
                    <x-input-label for="niveau" class="text-sm font-semibold text-gray-700">Niveau *</x-input-label>
                    <select name="niveau" id="niveau" required class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="">-- Sélectionner --</option>
                        <option value="BTS 1" @selected(old('niveau', $student->niveau) == 'BTS 1')>BTS 1</option>
                        <option value="BTS 2" @selected(old('niveau', $student->niveau) == 'BTS 2')>BTS 2</option>
                        <option value="Licence 1" @selected(old('niveau', $student->niveau) == 'Licence 1')>Licence 1</option>
                        <option value="Licence 2" @selected(old('niveau', $student->niveau) == 'Licence 2')>Licence 2</option>
                        <option value="Licence 3" @selected(old('niveau', $student->niveau) == 'Licence 3')>Licence 3</option>
                        <option value="Master 1" @selected(old('niveau', $student->niveau) == 'Master 1')>Master 1</option>
                        <option value="Master 2" @selected(old('niveau', $student->niveau) == 'Master 2')>Master 2</option>
                    </select>
                    <x-input-error :messages="$errors->get('niveau')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200 flex gap-3 justify-end">
                <a href="{{ route('students.show', $student) }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white hover:shadow-lg hover:from-blue-700 hover:to-blue-800 active:scale-95 transition-all duration-200 font-semibold">
                    <x-icon name="check" size="sm" class="w-4 h-4" />
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
