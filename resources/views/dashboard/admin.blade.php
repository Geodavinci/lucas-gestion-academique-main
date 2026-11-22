@extends('layouts.app')

@section('content')
<div class="space-y-12">
    <!-- Page Header -->
    <div>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 via-violet-600 to-indigo-600 bg-clip-text text-transparent mb-2">Tableau de Bord Administrateur</h1>
        <p class="text-gray-600 text-lg">Suivi complet de vos statistiques académiques et opérationnelles</p>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Students KPI -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-blue-100 text-xs font-semibold uppercase tracking-wider">Étudiants</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $stats['total_students'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="users" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers KPI -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-emerald-100 text-xs font-semibold uppercase tracking-wider">Enseignants</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $stats['total_teachers'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="users" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Memoires KPI -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-600 to-violet-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-violet-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-violet-100 text-xs font-semibold uppercase tracking-wider">Mémoires</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $stats['total_memoires'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="document" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Soutenances KPI -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-600 to-amber-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-amber-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-amber-100 text-xs font-semibold uppercase tracking-wider">Soutenances</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $stats['total_soutenances'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="calendar" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming KPI -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-600 to-rose-700 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-300"></div>
            <div class="relative bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl shadow-lg hover:shadow-2xl p-8 text-white transition-all duration-300 transform hover:scale-105 overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-rose-400 rounded-full -mr-8 -mt-8 opacity-10"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-rose-100 text-xs font-semibold uppercase tracking-wider">À venir (30j)</p>
                        <p class="text-5xl font-bold text-white mt-3 tracking-tight">{{ $stats['upcoming_soutenances'] }}</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4 group-hover:bg-white/30 transition-colors">
                        <x-icon name="alert-circle" class="w-8 h-8 text-white" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section Header -->
    <div class="mt-12 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Analyses et Statistiques</h2>
        <p class="text-gray-600">Vue détaillée de vos données académiques</p>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-blue-500 to-blue-600"></div>
            <x-chart
                type="bar"
                :labels="$memoiresByFiliereData['labels']"
                :datasets="$memoiresByFiliereData['datasets']"
                title="Mémoires par filière"
            />
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-violet-500 to-violet-600"></div>
            <x-chart
                type="bar"
                :labels="$memoiresByNiveauData['labels']"
                :datasets="$memoiresByNiveauData['datasets']"
                title="Mémoires par niveau"
            />
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-emerald-500 to-emerald-600"></div>
            <x-chart
                type="doughnut"
                :labels="$studentsByFiliereData['labels']"
                :datasets="$studentsByFiliereData['datasets']"
                title="Répartition des étudiants"
            />
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-amber-500 to-amber-600"></div>
            <x-chart
                type="line"
                :labels="$soutenancesByMonthData['labels']"
                :datasets="$soutenancesByMonthData['datasets']"
                title="Soutenances par mois"
            />
        </div>
    </div>

    <!-- Teacher Workload Section -->
    <div class="mt-12">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 overflow-hidden">
            <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-rose-500 to-rose-600"></div>
            <x-chart
                type="bar"
                :labels="$teacherWorkloadData['labels']"
                :datasets="$teacherWorkloadData['datasets']"
                title="Charge de travail des enseignants"
                height="h-72"
            />
        </div>
    </div>

    <!-- Latest Data Tables Section -->
    <div class="mt-12 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Activités Récentes</h2>
        <p class="text-gray-600">Derniers mémoires et soutenances programmées</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Latest Memoires -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-50 via-white to-blue-50 border-b border-gray-100 relative">
                <div class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700"></div>
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100">
                        <x-icon name="document" class="w-6 h-6 text-blue-600" />
                    </span>
                    Derniers mémoires
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($latestMemoires as $memoire)
                    <div class="px-8 py-5 hover:bg-gradient-to-r hover:from-blue-50 to-transparent transition-all duration-200 group border-l-4 border-transparent hover:border-blue-500">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <a href="{{ route('memoires.show', $memoire) }}" class="font-semibold text-gray-900 hover:text-blue-600 transition-colors text-lg">{{ $memoire->titre }}</a>
                                <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                                    <x-icon name="user" class="w-4 h-4 text-gray-400" />
                                    {{ $memoire->student_full_name }}
                                </p>
                                <p class="text-xs text-gray-500 mt-2 flex items-center gap-2">
                                    <x-icon name="calendar" class="w-4 h-4 text-gray-400" />
                                    {{ $memoire->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <a href="{{ route('memoires.show', $memoire) }}" class="text-blue-600 hover:text-blue-700 opacity-0 group-hover:opacity-100 transition-opacity ml-4 flex-shrink-0">
                                <x-icon name="arrow-right" class="w-6 h-6" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-8 py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                <x-icon name="document" class="w-8 h-8 text-gray-400" />
                            </div>
                            <p class="text-gray-600 font-medium">Aucun mémoire</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Latest Soutenances -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
            <div class="px-8 py-6 bg-gradient-to-r from-amber-50 via-white to-amber-50 border-b border-gray-100 relative">
                <div class="absolute left-0 top-0 h-1 w-full bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700"></div>
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-100">
                        <x-icon name="calendar" class="w-6 h-6 text-amber-600" />
                    </span>
                    Prochaines soutenances
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($latestSoutenances as $soutenance)
                    <div class="px-8 py-5 hover:bg-gradient-to-r hover:from-amber-50 to-transparent transition-all duration-200 group border-l-4 border-transparent hover:border-amber-500">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <a href="{{ route('soutenances.show', $soutenance) }}" class="font-semibold text-gray-900 hover:text-amber-600 transition-colors text-lg">{{ $soutenance->student_full_name }}</a>
                                @if($soutenance->date_soutenance)
                                    <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                                        <x-icon name="calendar" class="w-4 h-4 text-gray-400" />
                                        {{ $soutenance->date_soutenance->format('d/m/Y H:i') }}
                                    </p>
                                @endif
                                <p class="text-xs text-gray-500 mt-2 flex items-center gap-2">
                                    <x-icon name="map-pin" class="w-4 h-4 text-gray-400" />
                                    {{ $soutenance->lieu ?? 'Lieu à déterminer' }}
                                </p>
                            </div>
                            <a href="{{ route('soutenances.show', $soutenance) }}" class="text-amber-600 hover:text-amber-700 opacity-0 group-hover:opacity-100 transition-opacity ml-4 flex-shrink-0">
                                <x-icon name="arrow-right" class="w-6 h-6" />
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-8 py-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                <x-icon name="calendar" class="w-8 h-8 text-gray-400" />
                            </div>
                            <p class="text-gray-600 font-medium">Aucune soutenance</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
