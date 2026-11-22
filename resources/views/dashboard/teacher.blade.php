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
                <p class="text-blue-100 text-sm font-semibold uppercase tracking-widest mb-3">Tableau de bord enseignant</p>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">Bienvenue, {{ $teacherStats['name'] }}</h1>
                <p class="text-xl text-blue-50 opacity-90">Suivi complet de votre charge de travail et de vos responsabilités académiques</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Director -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-blue-100 text-xs font-semibold uppercase tracking-wider">Directeur</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $teacherStats['soutenances_as_director'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="user" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluator -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wider">Évaluateur</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $teacherStats['soutenances_as_evaluator'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="check" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- President -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-600 to-violet-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-violet-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-violet-100 text-xs font-semibold uppercase tracking-wider">Président jury</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $teacherStats['soutenances_as_president'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="document" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Total -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-600 to-amber-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-amber-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-amber-100 text-xs font-semibold uppercase tracking-wider">Total</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $teacherStats['total_soutenances'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="calendar" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Soutenances Section -->
    <div class="mt-12 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Prochaines Soutenances</h2>
        <p class="text-gray-600">Vos engagements académiques à venir</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
        <div class="px-8 py-6 bg-gradient-to-r from-blue-50 via-white to-blue-50 border-b border-gray-100 relative">
            <div class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700"></div>
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100">
                    <x-icon name="calendar" class="w-6 h-6 text-blue-600" />
                </span>
                Soutenances programmées
            </h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($upcomingSoutenances as $soutenance)
                <div class="px-8 py-6 hover:bg-gradient-to-r hover:from-blue-50 to-transparent transition-all duration-200 group border-l-4 border-transparent hover:border-blue-500">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 text-lg">{{ $soutenance->student_full_name }}</p>
                            @if($soutenance->date_soutenance)
                                <p class="text-sm text-gray-600 mt-3 flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-blue-100">
                                        <x-icon name="calendar" size="sm" class="w-3 h-3 text-blue-600" />
                                    </span>
                                    <span class="font-medium">{{ $soutenance->date_soutenance->format('d/m/Y à H:i') }}</span>
                                </p>
                            @endif
                            <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-100">
                                    <x-icon name="map-pin" size="sm" class="w-3 h-3 text-amber-600" />
                                </span>
                                {{ $soutenance->lieu ?? 'Lieu à déterminer' }}
                            </p>
                        </div>
                        <a href="{{ route('soutenances.show', $soutenance) }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity ml-4 flex-shrink-0">
                            <span>Consulter</span>
                            <x-icon name="arrow-right" size="sm" class="w-5 h-5" />
                        </a>
                    </div>
                </div>
            @empty
                <div class="px-8 py-12 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                            <x-icon name="calendar" class="w-8 h-8 text-gray-400" />
                        </div>
                        <p class="text-gray-600 font-medium">Aucune soutenance prévue</p>
                        <p class="text-gray-500 text-sm">Vous serez notifié dès qu'une soutenance vous sera assignée</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
