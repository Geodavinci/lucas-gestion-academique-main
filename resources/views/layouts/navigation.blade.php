<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <x-application-logo class="block h-10 w-auto fill-current text-slate-900" />
                    <div>
                        <p class="text-lg font-semibold text-slate-900">{{ config('app.name', 'Lucas Gestion Académique') }}</p>
                        <p class="text-sm text-slate-500">Bienvenue dans votre espace de gestion.</p>
                    </div>
                </a>
            </div>

            <div class="hidden lg:flex lg:items-center lg:space-x-4">
                @auth
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Tableau de bord
                    </x-nav-link>
                    <x-nav-link :href="route('memoires.index')" :active="request()->routeIs('memoires.*')">
                        Mémoires
                    </x-nav-link>
                    <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                        Étudiants
                    </x-nav-link>
                    <x-nav-link :href="route('recu-paiements.index')" :active="request()->routeIs('recu-paiements.*')">
                        Reçus
                    </x-nav-link>
                    <x-nav-link :href="route('soutenances.index')" :active="request()->routeIs('soutenances.*')">
                        Soutenances
                    </x-nav-link>
                @endauth
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <div class="hidden sm:flex sm:items-center sm:gap-3">
                        <div class="text-sm text-slate-600">Bonjour, <span class="font-semibold text-slate-900">{{ explode(' ', Auth::user()->name)[0] }}</span></div>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-slate-200 text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    Mon profil
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        Se déconnecter
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="hidden sm:flex sm:items-center sm:gap-3">
                        <a href="{{ route('login') }}" class="text-sm text-slate-700 hover:text-slate-900">Connexion</a>
                        <a href="{{ route('register') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm text-white hover:bg-slate-800">Inscription</a>
                    </div>
                @endauth

                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-700 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Tableau de bord
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('memoires.index')" :active="request()->routeIs('memoires.*')">
                    Mémoires
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                    Étudiants
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('recu-paiements.index')" :active="request()->routeIs('recu-paiements.*')">
                    Reçus
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('soutenances.index')" :active="request()->routeIs('soutenances.*')">
                    Soutenances
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('login')">
                    Connexion
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    Inscription
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-slate-200">
                <div class="px-4">
                    <div class="font-medium text-base text-slate-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        Mon profil
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Se déconnecter
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
