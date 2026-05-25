@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<x-breadcrumb :items="[
    ['label' => 'Reçus de Paiement', 'url' => route('recu-paiements.index')],
    ['label' => $recu->numero_recu],
    ['label' => 'Modifier']
]" />

<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 via-green-500 to-teal-500 bg-clip-text text-transparent">Modifier le reçu de paiement</h1>
        <p class="mt-2 text-gray-600 text-lg">Mettez à jour les informations ci-dessous</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
        <form method="POST" action="{{ route('recu-paiements.update', $recu) }}" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Étudiant -->
                <div class="md:col-span-2">
                    <x-input-label for="student_id" class="text-sm font-semibold text-gray-700">Étudiant *</x-input-label>
                    <select name="student_id" id="student_id" required class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        <option value="">-- Sélectionner un étudiant --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id', $recu->student_id) == $student->id)>
                                {{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('student_id')" />
                </div>

                <!-- Numéro de reçu -->
                <div>
                    <x-input-label for="numero_recu" class="text-sm font-semibold text-gray-700">Numéro de reçu *</x-input-label>
                    <x-text-input
                        id="numero_recu"
                        name="numero_recu"
                        type="text"
                        value="{{ old('numero_recu', $recu->numero_recu) }}"
                        placeholder="Ex: REC-2024-001"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    />
                    <x-input-error :messages="$errors->get('numero_recu')" />
                </div>

                <!-- Montant -->
                <div>
                    <x-input-label for="montant" class="text-sm font-semibold text-gray-700">Montant *</x-input-label>
                    <x-text-input
                        id="montant"
                        name="montant"
                        type="number"
                        step="0.01"
                        value="{{ old('montant', $recu->montant) }}"
                        placeholder="Ex: 1500000"
                        required
                        class="mt-2 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    />
                    <x-input-error :messages="$errors->get('montant')" />
                </div>

                <!-- Date de paiement -->
                <div>
                    <x-input-label for="date_paiement" class="text-sm font-semibold text-gray-700">Date de paiement *</x-input-label>
                    <input
                        type="date"
                        id="date_paiement"
                        name="date_paiement"
                        value="{{ old('date_paiement', $recu->date_paiement) }}"
                        required
                        class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
                    />
                    <x-input-error :messages="$errors->get('date_paiement')" />
                </div>

                <!-- Fichier PDF -->
                <div class="md:col-span-2">
                    <x-input-label for="fichier_pdf" class="text-sm font-semibold text-gray-700">Fichier PDF</x-input-label>
                    <input
                        type="file"
                        id="fichier_pdf"
                        name="fichier_pdf"
                        accept=".pdf"
                        class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
                    />
                    @if ($recu->fichier_pdf)
                        <p class="text-xs text-gray-500 mt-2">PDF actuel: <a class="text-emerald-600 hover:underline" href="{{ asset('storage/' . $recu->fichier_pdf) }}" target="_blank">Télécharger</a></p>
                    @endif
                    <x-input-error :messages="$errors->get('fichier_pdf')" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200 flex gap-3 justify-end">
                <a href="{{ route('recu-paiements.show', $recu) }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
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