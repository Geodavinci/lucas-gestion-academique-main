@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Mémoires', 'url' => route('memoires.index')],
    ['label' => $memoire->titre, 'url' => route('memoires.show', $memoire)],
    ['label' => 'Modifier']
]" />

<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 bg-clip-text text-transparent">Modifier le mémoire</h1>
        <p class="mt-2 text-gray-600 text-lg">Mettez à jour les informations ci-dessous</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
        <form method="POST" action="{{ route('memoires.update', $memoire) }}" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Étudiant -->
                <div class="md:col-span-2">
                    <x-input-label for="student_id" class="text-sm font-semibold text-gray-700">Étudiant *</x-input-label>
                    <select name="student_id" id="student_id" required class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        <option value="">-- Sélectionner un étudiant --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id', $memoire->student_id) == $student->id)>
                                {{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('student_id')" />
                </div>

                <!-- Titre -->
                <div class="md:col-span-2">
                    <x-input-label for="titre" class="text-sm font-semibold text-gray-700">Titre *</x-input-label>
                    <x-text-input
                        id="titre"
                        name="titre"
                        type="text"
                        value="{{ old('titre', $memoire->titre) }}"
                        placeholder="Ex: Étude sur les systèmes distribués"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    />
                    <x-input-error :messages="$errors->get('titre')" />
                </div>

                <!-- Année -->
                <div>
                    <x-input-label for="annee" class="text-sm font-semibold text-gray-700">Année *</x-input-label>
                    <x-text-input
                        id="annee"
                        name="annee"
                        type="text"
                        value="{{ old('annee', $memoire->annee) }}"
                        placeholder="Ex: 2024"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    />
                    <x-input-error :messages="$errors->get('annee')" />
                </div>

                <!-- Fichier PDF Original -->
                <div>
                    <x-input-label for="fichier_pdf" class="text-sm font-semibold text-gray-700">Fichier PDF</x-input-label>
                    <input
                        type="file"
                        id="fichier_pdf"
                        name="fichier_pdf"
                        accept=".pdf"
                        class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
                    />
                    @if ($memoire->fichier_pdf)
                        <p class="text-xs text-gray-500 mt-2">Fichier actuel: <a href="{{ route('memoires.download', $memoire) }}" target="_blank" class="text-emerald-600 hover:underline">Télécharger</a></p>
                    @endif
                    <x-input-error :messages="$errors->get('fichier_pdf')" />
                </div>

                <!-- Fichier PDF Corrigé -->
                <div>
                    <x-input-label for="fichier_pdf_corrige" class="text-sm font-semibold text-gray-700">Fichier PDF corrigé</x-input-label>
                    <input
                        type="file"
                        id="fichier_pdf_corrige"
                        name="fichier_pdf_corrige"
                        accept=".pdf"
                        class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
                    />
                    @if ($memoire->fichier_pdf_corrige)
                        <p class="text-xs text-gray-500 mt-2">Version corrigée: <a href="{{ route('memoires.download.corrige', $memoire) }}" target="_blank" class="text-emerald-600 hover:underline">Télécharger</a></p>
                    @endif
                    <x-input-error :messages="$errors->get('fichier_pdf_corrige')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200 flex gap-3 justify-end">
                <a href="{{ route('memoires.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-700 text-white hover:shadow-lg hover:from-emerald-700 hover:to-teal-800 active:scale-95 transition-all duration-200 font-semibold">
                    <x-icon name="check" size="sm" class="w-4 h-4" />
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection