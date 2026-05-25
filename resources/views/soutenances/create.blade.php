@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Soutenances', 'url' => route('soutenances.index')],
    ['label' => 'Ajouter une soutenance']
]" />

<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 via-rose-500 to-pink-500 bg-clip-text text-transparent">Ajouter une soutenance</h1>
        <p class="mt-2 text-gray-600 text-lg">Remplissez les informations ci-dessous</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
        <form method="POST" action="{{ route('soutenances.store') }}" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Étudiant -->
                <div>
                    <x-input-label for="student_id" class="text-sm font-semibold text-gray-700">Étudiant *</x-input-label>
                    @if(isset($student))
                        <p class="text-xs text-gray-500 mb-2">Présélectionné depuis la fiche étudiant</p>
                    @endif
                    <select name="student_id" id="student_id" required class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
                        @if(isset($student))
                            <option value="{{ $student->id }}" selected>
                                {{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})
                            </option>
                        @else
                            <option value="">-- Sélectionner un étudiant --</option>
                        @endif
                        @foreach ($students as $s)
                            @if(!isset($student) || $s->id != $student->id)
                                <option value="{{ $s->id }}" @selected(old('student_id') == $s->id)>
                                    {{ $s->nom }} {{ $s->prenom }} ({{ $s->matricule }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('student_id')" />
                </div>

                <!-- Date de soutenance -->
                <div>
                    <x-input-label for="date_soutenance" class="text-sm font-semibold text-gray-700">Date de soutenance *</x-input-label>
                    <input
                        type="date"
                        id="date_soutenance"
                        name="date_soutenance"
                        value="{{ old('date_soutenance') }}"
                        required
                        class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white"
                    />
                    <x-input-error :messages="$errors->get('date_soutenance')" />
                </div>

                <!-- Statut -->
                <div>
                    <x-input-label for="statut" class="text-sm font-semibold text-gray-700">Statut *</x-input-label>
                    <select name="statut" id="statut" required class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
                        <option value="">-- Sélectionner un statut --</option>
                        <option value="Valide" @selected(old('statut') == 'Valide')>Validé</option>
                        <option value="Ajourne" @selected(old('statut') == 'Ajourne')>Ajourné</option>
                    </select>
                    <x-input-error :messages="$errors->get('statut')" />
                </div>

                <!-- Directeur de mémoire -->
                <div>
                    <x-input-label for="directeur_memoire_id" class="text-sm font-semibold text-gray-700">Directeur de mémoire</x-input-label>
                    <select name="directeur_memoire_id" id="directeur_memoire_id" class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
                        <option value="">-- Sélectionner un enseignant --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(old('directeur_memoire_id') == $teacher->id)>
                                {{ $teacher->nom }} {{ $teacher->prenom }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('directeur_memoire_id')" />
                </div>

                <!-- Évaluateur -->
                <div>
                    <x-input-label for="evaluateur_id" class="text-sm font-semibold text-gray-700">Évaluateur</x-input-label>
                    <select name="evaluateur_id" id="evaluateur_id" class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
                        <option value="">-- Sélectionner un enseignant --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(old('evaluateur_id') == $teacher->id)>
                                {{ $teacher->nom }} {{ $teacher->prenom }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('evaluateur_id')" />
                </div>

                <!-- Président du jury -->
                <div>
                    <x-input-label for="president_jury_id" class="text-sm font-semibold text-gray-700">Président du jury</x-input-label>
                    <select name="president_jury_id" id="president_jury_id" class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
                        <option value="">-- Sélectionner un enseignant --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @selected(old('president_jury_id') == $teacher->id)>
                                {{ $teacher->nom }} {{ $teacher->prenom }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('president_jury_id')" />
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <x-input-label for="description" class="text-sm font-semibold text-gray-700">Description</x-input-label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Remarques ou notes supplémentaires..."
                        class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white"
                    >{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200 flex gap-3 justify-end">
                <a href="{{ route('soutenances.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-orange-600 to-rose-700 text-white hover:shadow-lg hover:from-orange-700 hover:to-rose-800 active:scale-95 transition-all duration-200 font-semibold">
                    <x-icon name="check" size="sm" class="w-4 h-4" />
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
