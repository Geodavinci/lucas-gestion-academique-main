@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-violet-600 via-purple-500 to-pink-500 bg-clip-text text-transparent">Enseignants</h1>
            <p class="mt-2 text-gray-600 text-lg">Gérez et consultez la liste complète des enseignants enregistrés</p>
        </div>
        <a href="{{ route('teachers.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-purple-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold hover:from-violet-700 hover:to-purple-800">
            <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
            Ajouter un enseignant
        </a>
    </div>

    <!-- Search Filter -->
    <form method="GET" class="bg-white rounded-2xl shadow-md border border-gray-100/50 p-6 backdrop-blur-sm">
        <div class="flex gap-4">
            <div class="flex-1">
                <x-input-label for="q" class="text-sm font-semibold text-gray-700">Recherche</x-input-label>
                <x-text-input
                    id="q"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Nom, email, spécialité..."
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
            <div class="flex items-end">
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-purple-700 text-white px-6 py-2.5 rounded-xl hover:shadow-lg hover:from-violet-700 hover:to-purple-800 active:scale-95 transition-all duration-200 font-semibold">
                    <x-icon name="search" size="sm" class="w-4 h-4" />
                    Rechercher
                </button>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-violet-50 via-white to-purple-50 border-b-2 border-violet-100">
                <tr>
                    <th class="text-left px-6 py-4 font-bold text-violet-900 text-xs uppercase tracking-widest">Nom</th>
                    <th class="text-left px-6 py-4 font-bold text-violet-900 text-xs uppercase tracking-widest">Email</th>
                    <th class="text-left px-6 py-4 font-bold text-violet-900 text-xs uppercase tracking-widest">Spécialité</th>
                    <th class="text-right px-6 py-4 font-bold text-violet-900 text-xs uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($teachers as $teacher)
                    <tr class="hover:bg-violet-50 hover:border-l-4 hover:border-l-violet-500 transition-all duration-200 group">
                        <td class="px-6 py-4 font-bold text-gray-900 text-sm">{{ $teacher->nom }} {{ $teacher->prenom }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $teacher->email ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $teacher->specialite }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- View Button -->
                                <a href="{{ route('teachers.show', $teacher) }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Voir">
                                    <x-icon name="eye" size="sm" class="w-4 h-4" />
                                    <span class="hidden sm:inline">Voir</span>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('teachers.edit', $teacher) }}" class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Modifier">
                                    <x-icon name="pencil" size="sm" class="w-4 h-4" />
                                    <span class="hidden sm:inline">Modifier</span>
                                </a>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('teachers.destroy', $teacher) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')">
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
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="bg-gradient-to-br from-violet-100 to-purple-100 rounded-full p-6">
                                    <x-icon name="users" size="lg" class="w-12 h-12 text-violet-600" />
                                </div>
                                <div>
                                    <p class="text-gray-900 font-bold text-lg">Aucun enseignant enregistré</p>
                                    <p class="text-gray-600 text-sm mt-2">Commencez par ajouter le premier enseignant au système</p>
                                </div>
                                <a href="{{ route('teachers.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-purple-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold">
                                    <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                                    Ajouter un enseignant
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $teachers->links('vendor/pagination/custom') }}
</div>
@endsection
