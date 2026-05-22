@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 via-green-500 to-teal-500 bg-clip-text text-transparent">Reçus de Paiement</h1>
            <p class="mt-2 text-gray-600 text-lg">Gérez les reçus de paiement des étudiants</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('recu-paiements.export', request()->query()) }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold">
                <x-icon name="download" size="sm" class="w-4 h-4" />
                Exporter CSV
            </a>
            <a href="{{ route('recu-paiements.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold hover:from-emerald-700 hover:to-teal-800">
                <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                Ajouter un reçu
            </a>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white rounded-2xl shadow-md border border-gray-100/50 p-6 backdrop-blur-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="q" class="text-sm font-semibold text-gray-700">Recherche</x-input-label>
                <x-text-input
                    id="q"
                    name="q"
                    value="{{ $search ?? '' }}"
                    placeholder="Numéro reçu, étudiant"
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
            <div>
                <x-input-label for="date" class="text-sm font-semibold text-gray-700">Date</x-input-label>
                <x-text-input
                    id="date"
                    type="date"
                    name="date"
                    value="{{ $date ?? '' }}"
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
            <div class="flex items-end">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-700 text-white px-4 py-2.5 rounded-xl hover:shadow-lg hover:from-emerald-700 hover:to-teal-800 active:scale-95 transition-all duration-200 font-semibold">
                    <x-icon name="search" size="sm" class="w-4 h-4" />
                    Filtrer
                </button>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white shadow-lg rounded-2xl border border-gray-100/50 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-emerald-50 via-white to-teal-50 border-b-2 border-emerald-100">
                <tr>
                    <th class="text-left px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Numéro</th>
                    <th class="text-left px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Étudiant</th>
                    <th class="text-left px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Montant</th>
                    <th class="text-left px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Date</th>
                    <th class="text-right px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($recus as $recu)
                    <tr class="hover:bg-emerald-50 hover:border-l-4 hover:border-l-emerald-500 transition-all duration-200 group">
                        <td class="px-6 py-4 font-bold text-gray-900 text-sm">{{ $recu->numero_recu }}</td>
                        <td class="px-6 py-4 text-gray-900 text-sm font-semibold">{{ $recu->student?->nom }} {{ $recu->student?->prenom }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm font-bold bg-gradient-to-r from-green-50 to-emerald-50 px-4 py-2 rounded-lg w-fit">{{ number_format($recu->montant, 2, '.', ' ') }} FCFA</td>
                        <td class="px-6 py-4 text-gray-600 text-sm font-medium">{{ $recu->date_paiement }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('recu-paiements.show', $recu) }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Voir">
                                    <x-icon name="eye" size="sm" class="w-4 h-4" />
                                    <span class="hidden sm:inline">Voir</span>
                                </a>
                                <a href="{{ route('recu-paiements.edit', $recu) }}" class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Modifier">
                                    <x-icon name="pencil" size="sm" class="w-4 h-4" />
                                    <span class="hidden sm:inline">Modifier</span>
                                </a>
                                <form method="POST" action="{{ route('recu-paiements.destroy', $recu) }}" class="inline" data-confirm="Êtes-vous sûr de vouloir supprimer ce reçu ?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Supprimer">
                                        <x-icon name="trash" size="sm" class="w-4 h-4" />
                                        <span class="hidden sm:inline">Supprimer</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-20 text-center" colspan="5">
                            <div class="flex flex-col items-center gap-6">
                                <div class="bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full p-6">
                                    <x-icon name="document" size="lg" class="w-12 h-12 text-emerald-600" />
                                </div>
                                <div>
                                    <p class="text-gray-900 font-bold text-lg">Aucun reçu enregistré</p>
                                    <p class="text-gray-600 text-sm mt-2">Commencez par ajouter le premier reçu de paiement</p>
                                </div>
                                <a href="{{ route('recu-paiements.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold">
                                    <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                                    Ajouter un reçu
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $recus->links('vendor/pagination/custom') }}
    </div>
</div>
@endsection
