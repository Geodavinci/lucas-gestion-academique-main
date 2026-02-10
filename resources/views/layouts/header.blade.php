<nav class="bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('students.index') }}" class="text-lg font-semibold">Memoire Manager</a>
        <div class="flex items-center gap-4 text-sm">
            @auth
                <a href="{{ route('app.home') }}" class="hover:text-slate-600">Dashboard</a>
                <a href="{{ route('students.index') }}" class="hover:text-slate-600">Etudiants</a>
                <a href="{{ route('memoires.index') }}" class="hover:text-slate-600">Memoires</a>
                <a href="{{ route('teachers.index') }}" class="hover:text-slate-600">Enseignants</a>
                <a href="{{ route('soutenances.index') }}" class="hover:text-slate-600">Soutenances</a>
                <a href="{{ route('recu-paiements.index') }}" class="hover:text-slate-600">Recus</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-rose-600 hover:text-rose-700">Deconnexion</button>
                </form>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="hover:text-slate-600">Connexion</a>
                <a href="{{ route('register') }}" class="hover:text-slate-600">Inscription</a>
            @endguest
        </div>
    </div>
</nav>
