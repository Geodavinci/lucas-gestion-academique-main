<nav x-data="{ open: false }" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200/30 dark:border-gray-700/30 shadow-md dark:shadow-gray-950/50 sticky top-0 z-50 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo & Brand -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 hover:opacity-90 transition-opacity py-2 px-1">
                    <x-application-logo class="block h-8 w-auto fill-current text-blue-600" />
                    <div class="hidden sm:flex flex-col leading-tight">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-widest">Lucas</span>
                        <span class="text-sm font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Gestion Académique</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden lg:flex lg:items-center lg:gap-1">
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

            <!-- Right Section -->
            <div class="flex items-center gap-2">
                <!-- Theme Toggle -->
                <x-theme-toggle />

                @auth
                    <!-- Notification Bell -->
                    <div class="relative">
                        <x-notification-bell />
                    </div>

                    <!-- User Menu -->
                    <div class="hidden sm:block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                                    <x-icon name="user" size="sm" class="w-5 h-5" />
                                    <span class="hidden md:inline max-w-[150px] truncate">{{ Auth::user()->name }}</span>
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
                    <!-- Login/Register Links -->
                    <div class="hidden sm:flex sm:items-center sm:gap-2">
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-blue-600 text-sm font-medium text-white hover:bg-blue-700 transition-colors duration-200">
                            S'inscrire
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:bg-gray-100 sm:hidden transition-colors duration-200">
                    <x-icon x-show="!open" name="menu" size="md" class="w-6 h-6" />
                    <x-icon x-show="open" name="x" size="md" class="w-6 h-6" />
                </button>
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
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-600">{{ Auth::user()->email }}</div>
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
