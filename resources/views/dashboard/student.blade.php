@extends('layouts.app')

@section('content')
<div class="space-y-12">
    <!-- Welcome Card -->
    <div class="relative overflow-hidden rounded-3xl shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800"></div>
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-white rounded-full -ml-36 -mb-36"></div>
        </div>
        <div class="relative px-10 py-12 md:py-16">
            <div class="max-w-2xl">
                <p class="text-blue-100 text-sm font-semibold uppercase tracking-widest mb-3">Tableau de bord étudiant</p>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">Bienvenue, {{ $studentStats['name'] }}</h1>
                <div class="flex flex-wrap gap-6 mt-6">
                    <div class="text-blue-50">
                        <p class="text-xs font-semibold uppercase tracking-widest text-blue-100">Filière</p>
                        <p class="text-lg font-bold mt-1">{{ $studentStats['filiere'] }}</p>
                    </div>
                    <div class="text-blue-50">
                        <p class="text-xs font-semibold uppercase tracking-widest text-blue-100">Niveau</p>
                        <p class="text-lg font-bold mt-1">{{ $studentStats['niveau'] }}</p>
                    </div>
                    <div class="text-blue-50">
                        <p class="text-xs font-semibold uppercase tracking-widest text-blue-100">Matricule</p>
                        <p class="text-lg font-bold mt-1">{{ $studentStats['matricule'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Memoires Card -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-400 rounded-full -mr-12 -mt-12 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-blue-100 text-xs font-semibold uppercase tracking-wider">Mémoires</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $studentStats['memoires_count'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="document" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Soutenances Card -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-400 rounded-full -mr-12 -mt-12 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wider">Soutenances</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $studentStats['soutenances_count'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="calendar" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Soutenance -->
    @if($studentStats['next_soutenance'])
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-50 to-orange-50 border border-rose-200 p-8 shadow-lg">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-200 to-orange-200 rounded-full -mr-16 -mt-16 opacity-30"></div>
            <div class="relative z-10">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-gradient-to-br from-rose-500 to-orange-500">
                            <x-icon name="alert-circle" class="h-6 w-6 text-white" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Votre soutenance est programmée</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-rose-100">
                                    <x-icon name="calendar" class="w-4 h-4 text-rose-600" />
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-900">Date et heure</p>
                                    <p class="text-gray-700">{{ $studentStats['next_soutenance']->date_soutenance->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-100">
                                    <x-icon name="map-pin" class="w-4 h-4 text-orange-600" />
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-900">Lieu</p>
                                    <p class="text-gray-700">{{ $studentStats['next_soutenance']->lieu ?? 'À déterminer' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Mémoires Section -->
    <div class="mt-12 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Mes Mémoires</h2>
        <p class="text-gray-600">Gestion de vos documents académiques</p>
    </div>

    @if($studentStats['memoires']->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-50 via-white to-blue-50 border-b border-gray-100 relative">
                <div class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700"></div>
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100">
                        <x-icon name="document" class="w-6 h-6 text-blue-600" />
                    </span>
                    Mémoires en cours
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($studentStats['memoires'] as $memoire)
                    <div class="px-8 py-6 hover:bg-gradient-to-r hover:from-blue-50 to-transparent transition-all duration-200 group border-l-4 border-transparent hover:border-blue-500">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <a href="{{ route('memoires.show', $memoire) }}" class="font-semibold text-gray-900 hover:text-blue-600 transition-colors text-lg">{{ $memoire->titre }}</a>
                                <div class="flex flex-wrap gap-4 mt-3 text-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-blue-100">
                                            <x-icon name="calendar" class="w-3 h-3 text-blue-600" />
                                        </span>
                                        <span class="text-gray-600"><strong class="text-gray-900">Année:</strong> {{ $memoire->annee ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-gray-100">
                                            <x-icon name="calendar" class="w-3 h-3 text-gray-600" />
                                        </span>
                                        <span class="text-gray-600">Créé le {{ $memoire->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3 ml-4 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">
                                @if($memoire->fichier_pdf)
                                    <a href="{{ route('memoires.download', $memoire) }}" class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 px-4 py-2 rounded-xl transition-all font-medium" title="Télécharger">
                                        <x-icon name="download" size="sm" class="w-4 h-4" />
                                        <span>Télécharger</span>
                                    </a>
                                @endif
                                <a href="{{ route('memoires.show', $memoire) }}" class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 hover:bg-blue-200 px-4 py-2 rounded-xl transition-all font-medium" title="Voir">
                                    <span>Consulter</span>
                                    <x-icon name="arrow-right" size="sm" class="w-4 h-4" />
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center hover:shadow-xl transition-all duration-300">
            <div class="flex flex-col items-center gap-6">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                    <x-icon name="document" class="w-10 h-10 text-blue-600" />
                </div>
                <div>
                    <p class="text-gray-900 font-bold text-xl">Vous n'avez pas encore de mémoire</p>
                    <p class="text-gray-600 text-lg mt-2">Commencez par créer votre premier mémoire pour suivre votre travail académique</p>
                </div>
                <a href="{{ route('memoires.create') }}" class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                    <x-icon name="plus-circle" size="sm" class="w-5 h-5" />
                    Créer mon premier mémoire
                </a>
            </div>
        </div>
    @endif

    <!-- Quick Links Section -->
    <div class="mt-12 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Accès Rapide</h2>
        <p class="text-gray-600">Raccourcis vers vos ressources principales</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Memoires Link -->
        <a href="{{ route('memoires.index') }}" class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 border border-gray-100 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-100 rounded-full -mr-12 -mt-12 group-hover:bg-blue-200 transition-colors"></div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 group-hover:scale-110 transition-transform">
                        <x-icon name="document" class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-lg group-hover:text-blue-600 transition-colors">Tous les mémoires</p>
                        <p class="text-sm text-gray-600 mt-1 group-hover:text-gray-700">Consulter la liste complète</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Soutenances Link -->
        <a href="{{ route('soutenances.index') }}" class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 border border-gray-100 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-100 rounded-full -mr-12 -mt-12 group-hover:bg-emerald-200 transition-colors"></div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 group-hover:scale-110 transition-transform">
                        <x-icon name="calendar" class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-lg group-hover:text-emerald-600 transition-colors">Soutenances</p>
                        <p class="text-sm text-gray-600 mt-1 group-hover:text-gray-700">Voir mon calendrier</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Profile Link -->
        <a href="{{ route('student.profile') }}" class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-600 to-violet-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl p-8 border border-gray-100 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-violet-100 rounded-full -mr-12 -mt-12 group-hover:bg-violet-200 transition-colors"></div>
                <div class="flex items-start gap-4 relative z-10">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-violet-500 to-violet-600 group-hover:scale-110 transition-transform">
                        <x-icon name="user" class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-lg group-hover:text-violet-600 transition-colors">Mon dossier</p>
                        <p class="text-sm text-gray-600 mt-1 group-hover:text-gray-700">Télécharger en PDF</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
