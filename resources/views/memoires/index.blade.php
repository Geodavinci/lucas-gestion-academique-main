@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 bg-clip-text text-transparent">Mémoires</h1>
            <p class="mt-2 text-gray-600 text-lg">Consultez tous les mémoires enregistrés dans le système</p>
        </div>
        @if(auth()->user()?->role === 'admin')
            <a href="{{ route('memoires.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold hover:from-emerald-700 hover:to-teal-800">
                <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                Ajouter un mémoire
            </a>
        @endif
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white rounded-2xl shadow-md border border-gray-100/50 p-6 backdrop-blur-sm">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="q" class="text-sm font-semibold text-gray-700">Recherche</x-input-label>
                <x-text-input
                    id="q"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Titre du mémoire..."
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
            <div>
                <x-input-label for="annee" class="text-sm font-semibold text-gray-700">Année</x-input-label>
                <x-text-input
                    id="annee"
                    name="annee"
                    type="number"
                    value="{{ request('annee') }}"
                    placeholder="2026"
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
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-emerald-50 via-white to-teal-50 border-b-2 border-emerald-100">
                <tr>
                    <th class="text-left px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Titre</th>
                    <th class="text-left px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Étudiant</th>
                    <th class="text-left px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Année</th>
                    <th class="text-right px-6 py-4 font-bold text-emerald-900 text-xs uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($memoires as $memoire)
                    <tr class="hover:bg-emerald-50 hover:border-l-4 hover:border-l-emerald-500 transition-all duration-200 group">
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('memoires.show', $memoire) }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                                {{ $memoire->titre }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm font-medium">
                            {{ $memoire->student?->nom }} {{ $memoire->student?->prenom }}
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm font-semibold">{{ $memoire->annee }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- View Button -->
                                <a href="{{ route('memoires.show', $memoire) }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Voir">
                                    <x-icon name="eye" size="sm" class="w-4 h-4" />
                                    <span class="hidden sm:inline">Voir</span>
                                </a>

                                <!-- Download Button -->
                                @if ($memoire->fichier_pdf)
                                    <a href="{{ route('memoires.download', $memoire) }}" class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Télécharger">
                                        <x-icon name="download" size="sm" class="w-4 h-4" />
                                        <span class="hidden sm:inline">Télécharger</span>
                                    </a>
                                @endif

                                @if (auth()->check())
                                    @can('update', $memoire)
                                    <a href="{{ route('memoires.edit', $memoire) }}" class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Modifier">
                                        <x-icon name="pencil" size="sm" class="w-4 h-4" />
                                        <span class="hidden sm:inline">Modifier</span>
                                    </a>
                                    @endcan

                                    @can('delete', $memoire)
                                    <form method="POST" action="{{ route('memoires.destroy', $memoire) }}" class="inline" data-confirm="Êtes-vous sûr de vouloir supprimer ce mémoire ?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Supprimer">
                                            <x-icon name="trash" size="sm" class="w-4 h-4" />
                                            <span class="hidden sm:inline">Supprimer</span>
                                        </button>
                                    </form>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full p-6">
                                    <x-icon name="document" size="lg" class="w-12 h-12 text-emerald-600" />
                                </div>
                                <div>
                                    <p class="text-gray-900 font-bold text-lg">Aucun mémoire enregistré</p>
                                    <p class="text-gray-600 text-sm mt-2">Il n'y a pas encore de mémoires dans le système</p>
                                </div>
                                @if(auth()->user()?->role === 'admin')
                                    <a href="{{ route('memoires.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold">
                                        <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                                        Ajouter un mémoire
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
    @if ($memoires->hasPages())
        <div class="flex justify-center">
            {{ $memoires->links('vendor/pagination/custom') }}
        </div>
    @endif
</div>
@endsection
