@extends('layouts.app')

@section('content')
@php
    $card = 'rounded-2xl border border-slate-200 bg-white/90 shadow-lg backdrop-blur transition-all duration-200 hover:shadow-xl';
    $cardHeader = 'flex items-center justify-between border-b border-slate-100 px-6 py-4';
    $cardBody = 'px-6 py-5';
@endphp

<div x-data="{ 
    tab: 'overview',
    search: '',
    sidebarOpen: false
}" class="relative min-h-screen">
    
    <!-- Mobile sidebar toggle -->
    <div class="lg:hidden fixed top-4 right-4 z-50">
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-full bg-white shadow-lg border border-slate-200">
            <svg x-show="!sidebarOpen" class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="sidebarOpen" class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
         class="fixed lg:sticky top-0 left-0 z-40 h-screen w-64 bg-white border-r border-slate-200 shadow-xl lg:shadow-none transition-transform duration-300 lg:block">
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-900 to-slate-700 flex items-center justify-center">
                    <span class="text-white font-bold">GM</span>
                </div>
                <div>
                    <h2 class="font-bold text-slate-900">Gestion Mémoires</h2>
                    <p class="text-xs text-slate-500">Tableau de bord</p>
                </div>
            </div>
        </div>
        
        <nav class="p-4 space-y-1">
            <button @click="tab = 'overview'; sidebarOpen = false" 
                    :class="tab === 'overview' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Vue d'ensemble</span>
            </button>
            
            <button @click="tab = 'students'; sidebarOpen = false" 
                    :class="tab === 'students' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-10a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                </svg>
                <span>Étudiants</span>
                <span class="ml-auto bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-full">{{ $stats['students'] }}</span>
            </button>
            
            <button @click="tab = 'teachers'; sidebarOpen = false" 
                    :class="tab === 'teachers' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span>Enseignants</span>
                <span class="ml-auto bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-full">{{ $stats['teachers'] }}</span>
            </button>
            
            <button @click="tab = 'memoires'; sidebarOpen = false" 
                    :class="tab === 'memoires' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Mémoires</span>
                <span class="ml-auto bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-full">{{ $stats['memoires'] }}</span>
            </button>
            
            <button @click="tab = 'soutenances'; sidebarOpen = false" 
                    :class="tab === 'soutenances' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Soutenances</span>
                <span class="ml-auto bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-full">{{ $stats['soutenances'] }}</span>
            </button>
            
            <button @click="tab = 'recus'; sidebarOpen = false" 
                    :class="tab === 'recus' ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-50'"
                    class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span>Reçus</span>
                <span class="ml-auto bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-full">{{ $stats['recus'] }}</span>
            </button>
        </nav>
    </div>

    <!-- Overlay for mobile -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" 
         class="fixed inset-0 bg-black/50 z-30 lg:hidden transition-opacity duration-300"></div>

    <!-- Main Content -->
    <div class="lg:ml-64">
        <!-- Header -->
        <div class="sticky top-0 z-20 bg-white/90 backdrop-blur-lg border-b border-slate-200">
            <div class="px-6 py-4">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Gestion des mémoires universitaires</h1>
                        <p class="mt-1 text-sm text-slate-600">Tout en un, organisé par sections pour agir vite.</p>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Search Bar -->
                        <div class="relative">
                            <input x-model="search" type="text" 
                                   placeholder="Rechercher..." 
                                   class="w-64 pl-10 pr-4 py-2 rounded-xl border border-slate-300 bg-white/80 focus:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200 text-sm">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        
                        <!-- User Profile -->
                        <div class="relative group">
                            <button class="flex items-center space-x-3 p-2 rounded-xl hover:bg-slate-50">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-900 to-slate-700"></div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Tab Navigation -->
                <div class="mt-4 overflow-x-auto">
                    <div class="flex space-x-2 pb-2 min-w-max">
                        <button type="button" @click="tab = 'overview'" 
                                :class="tab === 'overview' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-700 border border-slate-200 hover:border-slate-300'" 
                                class="rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200">
                            Vue d'ensemble
                        </button>
                        <button type="button" @click="tab = 'students'" 
                                :class="tab === 'students' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-700 border border-slate-200 hover:border-slate-300'" 
                                class="rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200">
                            Étudiants <span class="ml-2 text-xs bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded-full">{{ $stats['students'] }}</span>
                        </button>
                        <button type="button" @click="tab = 'teachers'" 
                                :class="tab === 'teachers' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-700 border border-slate-200 hover:border-slate-300'" 
                                class="rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200">
                            Enseignants <span class="ml-2 text-xs bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded-full">{{ $stats['teachers'] }}</span>
                        </button>
                        <button type="button" @click="tab = 'memoires'" 
                                :class="tab === 'memoires' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-700 border border-slate-200 hover:border-slate-300'" 
                                class="rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200">
                            Mémoires <span class="ml-2 text-xs bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded-full">{{ $stats['memoires'] }}</span>
                        </button>
                        <button type="button" @click="tab = 'soutenances'" 
                                :class="tab === 'soutenances' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-700 border border-slate-200 hover:border-slate-300'" 
                                class="rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200">
                            Soutenances <span class="ml-2 text-xs bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded-full">{{ $stats['soutenances'] }}</span>
                        </button>
                        <button type="button" @click="tab = 'recus'" 
                                :class="tab === 'recus' ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-700 border border-slate-200 hover:border-slate-300'" 
                                class="rounded-xl px-4 py-2 text-sm font-medium transition-all duration-200">
                            Reçus <span class="ml-2 text-xs bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded-full">{{ $stats['recus'] }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="p-6 space-y-6">
            <!-- Overview -->
            <div x-show="tab === 'overview'" x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="space-y-6">
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    @php
                        $statCards = [
                            ['label' => 'Étudiants', 'value' => $stats['students'], 'color' => 'emerald', 'icon' => '👨‍🎓'],
                            ['label' => 'Enseignants', 'value' => $stats['teachers'], 'color' => 'indigo', 'icon' => '👨‍🏫'],
                            ['label' => 'Mémoires', 'value' => $stats['memoires'], 'color' => 'amber', 'icon' => '📚'],
                            ['label' => 'Soutenances', 'value' => $stats['soutenances'], 'color' => 'sky', 'icon' => '🎤'],
                            ['label' => 'Reçus', 'value' => $stats['recus'], 'color' => 'rose', 'icon' => '🧾']
                        ];
                    @endphp
                    
                    @foreach ($statCards as $stat)
                    <div class="{{ $card }}">
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-2xl">{{ $stat['icon'] }}</span>
                                    <p class="mt-3 text-xs font-medium uppercase tracking-wider text-slate-500">{{ $stat['label'] }}</p>
                                </div>
                                <span class="h-3 w-3 rounded-full bg-{{ $stat['color'] }}-400 shadow-lg"></span>
                            </div>
                            <p class="mt-4 text-3xl font-bold text-slate-900">{{ $stat['value'] }}</p>
                            <div class="mt-4 h-1 rounded-full bg-slate-100">
                                <div class="h-1 rounded-full bg-{{ $stat['color'] }}-500" 
                                     style="width: {{ min(($stat['value'] / max(array_column($statCards, 'value'))) * 100, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Quick Actions -->
                <div class="{{ $card }}">
                    <div class="{{ $cardHeader }}">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Accès rapide</h2>
                            <p class="text-sm text-slate-500">Accédez directement aux sections principales</p>
                        </div>
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                    <div class="{{ $cardBody }}">
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-5">
                            @foreach ([
                                ['tab' => 'students', 'label' => 'Étudiants', 'icon' => '👨‍🎓', 'count' => $stats['students']],
                                ['tab' => 'teachers', 'label' => 'Enseignants', 'icon' => '👨‍🏫', 'count' => $stats['teachers']],
                                ['tab' => 'memoires', 'label' => 'Mémoires', 'icon' => '📚', 'count' => $stats['memoires']],
                                ['tab' => 'soutenances', 'label' => 'Soutenances', 'icon' => '🎤', 'count' => $stats['soutenances']],
                                ['tab' => 'recus', 'label' => 'Reçus', 'icon' => '🧾', 'count' => $stats['recus']]
                            ] as $item)
                            <button type="button" @click="tab = '{{ $item['tab'] }}'" 
                                    class="group rounded-xl border border-slate-200 bg-white p-4 text-left transition-all duration-200 hover:border-slate-300 hover:shadow-md">
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl">{{ $item['icon'] }}</span>
                                    <span class="text-xs font-medium text-slate-500">{{ $item['count'] }}</span>
                                </div>
                                <p class="mt-3 text-xs font-medium uppercase tracking-wider text-slate-500">{{ $item['label'] }}</p>
                                <p class="mt-1 text-sm font-semibold text-slate-900 group-hover:text-slate-950">Voir la liste</p>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Grid -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Recent Students -->
                    <div class="{{ $card }}">
                        <div class="{{ $cardHeader }}">
                            <h2 class="text-lg font-semibold text-slate-900">Derniers étudiants</h2>
                            <a href="{{ route('students.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Tout voir →</a>
                        </div>
                        <div class="{{ $cardBody }}">
                            <div class="space-y-4">
                                @forelse ($latestStudents as $student)
                                <div class="flex items-center justify-between py-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-slate-900 to-slate-700 flex items-center justify-center">
                                            <span class="text-xs font-medium text-white">{{ substr($student->prenom, 0, 1) }}{{ substr($student->nom, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">{{ $student->nom }} {{ $student->prenom }}</p>
                                            <p class="text-xs text-slate-500">{{ $student->matricule }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-slate-400">{{ $student->created_at->diffForHumans() }}</span>
                                </div>
                                @empty
                                <div class="py-4 text-center text-slate-500">
                                    <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="mt-2 text-sm">Aucun étudiant pour le moment</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent Teachers -->
                    <div class="{{ $card }}">
                        <div class="{{ $cardHeader }}">
                            <h2 class="text-lg font-semibold text-slate-900">Derniers enseignants</h2>
                            <a href="{{ route('teachers.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Tout voir →</a>
                        </div>
                        <div class="{{ $cardBody }}">
                            <div class="space-y-4">
                                @forelse ($latestTeachers as $teacher)
                                <div class="flex items-center justify-between py-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center">
                                            <span class="text-xs font-medium text-white">{{ substr($teacher->prenom, 0, 1) }}{{ substr($teacher->nom, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">{{ $teacher->nom }} {{ $teacher->prenom }}</p>
                                            <p class="text-xs text-slate-500">{{ $teacher->specialite }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-slate-400">{{ $teacher->created_at->diffForHumans() }}</span>
                                </div>
                                @empty
                                <div class="py-4 text-center text-slate-500">
                                    <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="mt-2 text-sm">Aucun enseignant pour le moment</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent Soutenances -->
                    <div class="{{ $card }}">
                        <div class="{{ $cardHeader }}">
                            <h2 class="text-lg font-semibold text-slate-900">Dernières soutenances</h2>
                            <a href="{{ route('soutenances.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Tout voir →</a>
                        </div>
                        <div class="{{ $cardBody }}">
                            <div class="space-y-4">
                                @forelse ($latestSoutenances as $soutenance)
                                <div class="flex items-center justify-between py-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-amber-500 to-amber-700 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-slate-900">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</p>
                                            <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($soutenance->date_soutenance)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs font-medium px-2 py-1 rounded-full 
                                        {{ $soutenance->statut == 'Valide' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                        {{ $soutenance->statut }}
                                    </span>
                                </div>
                                @empty
                                <div class="py-4 text-center text-slate-500">
                                    <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="mt-2 text-sm">Aucune soutenance pour le moment</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Recent Items -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Recent Memoires -->
                    <div class="{{ $card }}">
                        <div class="{{ $cardHeader }}">
                            <h2 class="text-lg font-semibold text-slate-900">Derniers mémoires</h2>
                            <a href="{{ route('memoires.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Tout voir →</a>
                        </div>
                        <div class="{{ $cardBody }}">
                            <div class="space-y-4">
                                @forelse ($latestMemoires as $memoire)
                                <div class="flex items-center justify-between py-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-slate-900 truncate">{{ $memoire->titre }}</p>
                                            <p class="text-xs text-slate-500">{{ $memoire->student?->nom }} {{ $memoire->student?->prenom }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('memoires.download', $memoire) }}" target="_blank" 
                                       class="text-sm font-medium text-sky-600 hover:text-sky-700">PDF</a>
                                </div>
                                @empty
                                <div class="py-4 text-center text-slate-500">
                                    <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="mt-2 text-sm">Aucun mémoire pour le moment</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Recent PDFs -->
                    <div class="{{ $card }}">
                        <div class="{{ $cardHeader }}">
                            <h2 class="text-lg font-semibold text-slate-900">PDF récents</h2>
                            <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">{{ count($latestPdfs) }}</span>
                        </div>
                        <div class="{{ $cardBody }}">
                            <div class="space-y-4">
                                @forelse ($latestPdfs as $memoire)
                                <div class="flex items-center justify-between py-2">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-rose-500 to-rose-700 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-slate-900 truncate">{{ $memoire->titre }}</p>
                                            <p class="text-xs text-slate-500">{{ $memoire->student?->nom }} {{ $memoire->student?->prenom }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('memoires.download', $memoire) }}" target="_blank" 
                                       class="rounded-lg border border-slate-200 px-3 py-1 text-xs font-medium text-slate-700 hover:border-slate-300 hover:bg-slate-50">
                                        Voir
                                    </a>
                                </div>
                                @empty
                                <div class="py-4 text-center text-slate-500">
                                    <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                    </svg>
                                    <p class="mt-2 text-sm">Aucun PDF pour le moment</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Distribution & Management -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Distribution Chart -->
                    <div class="{{ $card }}">
                        <div class="{{ $cardHeader }}">
                            <h2 class="text-lg font-semibold text-slate-900">Répartition rapide</h2>
                        </div>
                        <div class="{{ $cardBody }}">
                            @php
                                $max = max($stats['students'], $stats['teachers'], $stats['memoires'], $stats['soutenances'], $stats['recus']) ?: 1;
                                $distribution = [
                                    ['label' => 'Étudiants', 'value' => $stats['students'], 'color' => 'bg-emerald-500'],
                                    ['label' => 'Enseignants', 'value' => $stats['teachers'], 'color' => 'bg-indigo-500'],
                                    ['label' => 'Mémoires', 'value' => $stats['memoires'], 'color' => 'bg-amber-500'],
                                    ['label' => 'Soutenances', 'value' => $stats['soutenances'], 'color' => 'bg-sky-500'],
                                    ['label' => 'Reçus', 'value' => $stats['recus'], 'color' => 'bg-rose-500']
                                ];
                            @endphp
                            <div class="space-y-4">
                                @foreach ($distribution as $item)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium text-slate-700">{{ $item['label'] }}</span>
                                        <span class="font-bold text-slate-900">{{ $item['value'] }}</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-2 rounded-full {{ $item['color'] }} transition-all duration-1000 ease-out" 
                                             style="width: {{ ($item['value'] / $max) * 100 }}%"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Role Management (Admin Only) -->
                    @if (auth()->user() && auth()->user()->role === 'admin')
                    <div class="{{ $card }}">
                        <div class="{{ $cardHeader }}">
                            <h2 class="text-lg font-semibold text-slate-900">Gestion des rôles</h2>
                            <span class="text-xs bg-slate-900 text-white px-2 py-1 rounded-full">Admin</span>
                        </div>
                        <div class="{{ $cardBody }}">
                            @if (session('error'))
                                <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-rose-700">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-700">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="overflow-x-auto rounded-xl border border-slate-200">
                                <table class="w-full text-sm">
                                    <thead class="bg-slate-50">
                                        <tr class="text-left text-slate-600">
                                            <th class="px-4 py-3 font-medium">Utilisateur</th>
                                            <th class="px-4 py-3 font-medium">Rôle</th>
                                            <th class="px-4 py-3 font-medium text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse ($users as $user)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-4 py-3">
                                                <div class="font-medium text-slate-900">{{ $user->name }}</div>
                                                <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <form method="POST" action="{{ route('admin.users.role', $user) }}" 
                                                      class="flex items-center gap-2" x-data="{ role: '{{ $user->role }}' }">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="role" x-model="role"
                                                            class="rounded-lg border-slate-300 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                                                        <option value="user">Utilisateur</option>
                                                        <option value="admin">Administrateur</option>
                                                    </select>
                                                    <button type="submit" 
                                                            class="rounded-lg bg-slate-900 px-3 py-1.5 text-xs font-medium text-white hover:bg-slate-800">
                                                        Mettre à jour
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <form method="POST" action="{{ route('admin.users.student', $user) }}" 
                                                      class="inline-flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="student_id" 
                                                            class="rounded-lg border-slate-300 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                                                        <option value="">Lier un étudiant</option>
                                                        @foreach ($studentsList as $student)
                                                            <option value="{{ $student->id }}" @selected($user->student?->id === $student->id)>
                                                                {{ $student->nom }} {{ $student->prenom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" 
                                                            class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium hover:border-slate-400">
                                                        Lier
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="px-4 py-6 text-center text-slate-500" colspan="3">
                                                Aucun utilisateur à gérer
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Students Tab -->
            <div x-show="tab === 'students'" x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="space-y-6">
                @include('dashboard.sections.students')
            </div>

            <!-- Teachers Tab -->
            <div x-show="tab === 'teachers'" x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="space-y-6">
                @include('dashboard.sections.teachers')
            </div>

            <!-- Memoires Tab -->
            <div x-show="tab === 'memoires'" x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="space-y-6">
                @include('dashboard.sections.memoires')
            </div>

            <!-- Soutenances Tab -->
            <div x-show="tab === 'soutenances'" x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="space-y-6">
                @include('dashboard.sections.soutenances')
            </div>

            <!-- Recus Tab -->
            <div x-show="tab === 'recus'" x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 class="space-y-6">
                @include('dashboard.sections.recus')
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .animate-bounce-custom {
        animation: bounce 2s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
</style>

@endsection