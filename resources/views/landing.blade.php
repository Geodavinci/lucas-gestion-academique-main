<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des memoires universitaires</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <header class="bg-gradient-to-b from-slate-900 to-slate-950">
        <div class="max-w-6xl mx-auto px-6 py-12">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold">Memoire Manager</h1>
                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('login') }}" class="hover:text-slate-300">Connexion</a>
                    <a href="{{ route('register') }}" class="rounded bg-white text-slate-900 px-4 py-2">Creer un compte</a>
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-400">Projet academique</p>
                    <h2 class="mt-4 text-4xl md:text-5xl font-semibold leading-tight">Systeme de gestion des memoires universitaires</h2>
                    <p class="mt-4 text-slate-300 text-lg">
                        Centralisez, securisez et consultez facilement les memoires des etudiants.
                        Acces rapide par etudiant, annee et statut de validation.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('login') }}" class="rounded bg-emerald-400 text-slate-900 px-5 py-3 font-medium">Demarrer</a>
                        <a href="{{ route('register') }}" class="rounded border border-slate-700 px-5 py-3">Demander un acces</a>
                    </div>
                </div>
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold">Fonctionnalites principales</h3>
                    <ul class="mt-4 space-y-3 text-slate-300">
                        <li>Enregistrement des etudiants et de leurs memoires</li>
                        <li>Filtrage rapide par annee et recherche multi-criteres</li>
                        <li>Stockage securise des fichiers PDF</li>
                        <li>Authentification et controle d'acces</li>
                        <li>Suivi des soutenances et recus de paiement</li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <section class="py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold">Centralisation</h3>
                    <p class="mt-2 text-slate-400">Tous les memoires au meme endroit pour eviter la perte des documents physiques.</p>
                </div>
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold">Consultation rapide</h3>
                    <p class="mt-2 text-slate-400">Recherche par titre, annee et etudiant en quelques secondes.</p>
                </div>
                <div class="bg-slate-900/60 border border-slate-800 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold">Securite</h3>
                    <p class="mt-2 text-slate-400">Acces reserve aux utilisateurs autorises, telechargements proteges.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-t border-slate-800">
        <div class="max-w-6xl mx-auto px-6 py-8 text-sm text-slate-500">
            Systeme de gestion des memoires universitaires. ? {{ date('Y') }}
        </div>
    </footer>
</body>
</html>
