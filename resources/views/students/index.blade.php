@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 bg-clip-text text-transparent">Étudiants</h1>
            <p class="mt-2 text-gray-600 text-lg">Gérez et consultez la liste complète des étudiants enregistrés</p>
        </div>
        <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold hover:from-blue-700 hover:to-blue-800">
            <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
            Ajouter un étudiant
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white rounded-2xl shadow-md border border-gray-100/50 p-6 backdrop-blur-sm" x-data="{ autoSubmit: true }" @change="if(autoSubmit) $el.submit()">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <x-input-label for="filiere" class="text-sm font-semibold text-gray-700">Filière</x-input-label>
                <x-text-input
                    id="filiere"
                    name="filiere"
                    value="{{ request('filiere') }}"
                    placeholder="ex: Informatique"
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
            <div>
                <x-input-label for="niveau" class="text-sm font-semibold text-gray-700">Niveau</x-input-label>
                <x-text-input
                    id="niveau"
                    name="niveau"
                    value="{{ request('niveau') }}"
                    placeholder="ex: L3"
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
            <div>
                <x-input-label for="matricule" class="text-sm font-semibold text-gray-700">Matricule</x-input-label>
                <x-text-input
                    id="matricule"
                    name="matricule"
                    value="{{ request('matricule') }}"
                    placeholder="ex: STU001"
                    class="mt-2 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    @change="$el.closest('form').submit()"
                />
            </div>
            <div class="flex items-end">
                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2.5 rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-blue-800 active:scale-95 transition-all duration-200 font-semibold">
                    <x-icon name="search" size="sm" class="w-4 h-4" />
                    Filtrer
                </button>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-blue-50 via-white to-cyan-50 border-b-2 border-blue-100">
                <tr>
                    <th class="text-left px-6 py-4 font-bold text-blue-900 text-xs uppercase tracking-widest">#</th>
                    <th class="text-left px-6 py-4 font-bold text-blue-900 text-xs uppercase tracking-widest">Matricule</th>
                    <th class="text-left px-6 py-4 font-bold text-blue-900 text-xs uppercase tracking-widest">Nom</th>
                    <th class="text-left px-6 py-4 font-bold text-blue-900 text-xs uppercase tracking-widest">Email</th>
                    <th class="text-left px-6 py-4 font-bold text-blue-900 text-xs uppercase tracking-widest">Filière</th>
                    <th class="text-left px-6 py-4 font-bold text-blue-900 text-xs uppercase tracking-widest">Niveau</th>
                    <th class="text-right px-6 py-4 font-bold text-blue-900 text-xs uppercase tracking-widest">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($students as $student)
                    <tr class="hover:bg-blue-50 hover:border-l-4 hover:border-l-blue-500 transition-all duration-200 group">
                        <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $student->matricule }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $student->nom }} {{ $student->prenom }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $student->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $student->filiere }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 border border-blue-200">
                                {{ $student->niveau }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- View Button -->
                                <a href="{{ route('students.show', $student) }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Voir">
                                    <x-icon name="eye" size="sm" class="w-4 h-4" />
                                    <span class="hidden sm:inline">Voir</span>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-3.5 py-2 rounded-xl transition-all duration-200 font-semibold text-xs hover:shadow-md hover:scale-105" title="Modifier">
                                    <x-icon name="pencil" size="sm" class="w-4 h-4" />
                                    <span class="hidden sm:inline">Modifier</span>
                                </a>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline" data-confirm="Êtes-vous sûr de vouloir supprimer cet étudiant ?">
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
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-6">
                                <div class="bg-gradient-to-br from-blue-100 to-cyan-100 rounded-full p-6">
                                    <x-icon name="users" size="lg" class="w-12 h-12 text-blue-600" />
                                </div>
                                <div>
                                    <p class="text-gray-900 font-bold text-lg">Aucun étudiant enregistré</p>
                                    <p class="text-gray-600 text-sm mt-2">Commencez par ajouter le premier étudiant au système</p>
                                </div>
                                <a href="{{ route('students.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-300 font-semibold">
                                    <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                                    Ajouter un étudiant
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($students->hasPages())
        <div class="flex justify-center">
            {{ $students->links('vendor/pagination/custom') }}
        </div>
    @endif
</div>
@endsection
