@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 via-rose-500 to-pink-500 bg-clip-text text-transparent">Soutenances</h1>
            <p class="mt-2 text-gray-600 text-lg">Historique complet et gestion des soutenances</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('soutenances.export', request()->query()) }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold">
                <x-icon name="download" size="sm" class="w-4 h-4" />
                Exporter CSV
            </a>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('soutenances.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-600 to-rose-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold hover:from-orange-700 hover:to-rose-800">
                    <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                    Ajouter une soutenance
                </a>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white rounded-2xl shadow-md border border-gray-100/50 p-6 backdrop-blur-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <x-input-label for="q" class="text-sm font-semibold text-gray-700">Recherche</x-input-label>
                <x-text-input
                    id="q"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Nom de l'étudiant..."
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
            <div>
                <x-input-label for="statut" class="text-sm font-semibold text-gray-700">Statut</x-input-label>
                <select name="statut" class="mt-2 block w-full px-4 py-2.5 border border-gray-300 rounded-xl text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white" @change="$el.closest('form').submit()">
                    <option value="">Tous</option>
                    <option value="Valide" @selected(request('statut') == 'Valide')>Validée</option>
                    <option value="Ajourne" @selected(request('statut') == 'Ajourne')>Ajournée</option>
                </select>
            </div>
            <div>
                <x-input-label for="date" class="text-sm font-semibold text-gray-700">Date</x-input-label>
                <x-text-input
                    id="date"
                    name="date"
                    type="date"
                    value="{{ request('date') }}"
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-600 to-rose-700 text-white px-6 py-2.5 rounded-xl hover:shadow-lg hover:from-orange-700 hover:to-rose-800 active:scale-95 transition-all duration-200 font-semibold">
                <x-icon name="search" size="sm" class="w-4 h-4" />
                Filtrer
            </button>
            <a href="{{ route('soutenances.index') }}" class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold border border-gray-300">
                Réinitialiser
            </a>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-orange-50 via-white to-rose-50 border-b-2 border-orange-100">
                <tr>
                    <th class="text-left px-6 py-4 font-bold text-orange-900 text-xs uppercase tracking-widest">Date</th>
                    <th class="text-left px-6 py-4 font-bold text-orange-900 text-xs uppercase tracking-widest">Étudiant</th>
                    <th class="text-left px-6 py-4 font-bold text-orange-900 text-xs uppercase tracking-widest">Statut</th>
                    <th class="text-left px-6 py-4 font-bold text-orange-900 text-xs uppercase tracking-widest">Directeur</th>
                    <th class="text-right px-6 py-4 font-bold text-orange-900 text-xs uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($soutenances as $soutenance)
                    <tr class="hover:bg-orange-50 hover:border-l-4 hover:border-l-orange-500 transition-all duration-200 group">
                        <td class="px-6 py-4 text-gray-600 text-sm font-semibold">{{ $soutenance->date_soutenance?->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 font-bold text-gray-900 text-sm">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold {{ $soutenance->statut == 'Valide' ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 border border-green-200' : 'bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700 border border-amber-200' }}">
                                {{ $soutenance->statut ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $soutenance->directeurMemoire?->nom }} {{ $soutenance->directeurMemoire?->prenom }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('soutenances.show', $soutenance) }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Voir">
                                    <x-icon name="eye" size="sm" class="w-4 h-4" />
                                    <span class="hidden sm:inline">Voir</span>
                                </a>
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('soutenances.edit', $soutenance) }}" class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Modifier">
                                        <x-icon name="pencil" size="sm" class="w-4 h-4" />
                                        <span class="hidden sm:inline">Modifier / affecter le jury</span>
                                    </a>
                                    <form method="POST" action="{{ route('soutenances.destroy', $soutenance) }}" class="inline" data-confirm="Êtes-vous sûr de vouloir supprimer cette soutenance ?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Supprimer">
                                            <x-icon name="trash" size="sm" class="w-4 h-4" />
                                            <span class="hidden sm:inline">Supprimer</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="bg-gradient-to-br from-orange-100 to-rose-100 rounded-full p-6">
                                    <x-icon name="calendar" size="lg" class="w-12 h-12 text-orange-600" />
                                </div>
                                <div>
                                    <p class="text-gray-900 font-bold text-lg">Aucune soutenance enregistrée</p>
                                    <p class="text-gray-600 text-sm mt-2">Il n'y a pas encore de soutenances dans le système</p>
                                </div>
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('soutenances.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-orange-600 to-rose-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold">
                                        <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                                        Ajouter une soutenance
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($soutenances->hasPages())
        <div class="flex justify-center">
            {{ $soutenances->links('vendor/pagination/custom') }}
        </div>
    @endif
</div>
@endsection
