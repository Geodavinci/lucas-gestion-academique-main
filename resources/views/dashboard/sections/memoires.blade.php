<div class="flex items-center justify-between">
    <h2 class="text-lg font-semibold text-slate-900">Mémoires</h2>
    <button type="button" @click="tab = 'overview'" class="text-sm text-slate-600">Retour</button>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Ajouter un mémoire</h3>
    </div>
    <div class="{{ $cardBody }}">
        <form method="POST" action="{{ route('memoires.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf
            <select name="student_id" class="rounded-lg border-slate-300">
                <option value="">Sélectionner un étudiant</option>
                @foreach ($studentsList as $student)
                    <option value="{{ $student->id }}">{{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})</option>
                @endforeach
            </select>
            <input name="titre" placeholder="Titre" class="rounded-lg border-slate-300" />
            <input name="annee" placeholder="Année" class="rounded-lg border-slate-300" />
            <input type="file" name="fichier_pdf" class="rounded-lg border-slate-300 bg-white" />
            <div class="md:col-span-2">
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Liste récente</h3>
        <a href="{{ route('memoires.index') }}" class="text-sm text-slate-600">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-4 py-3">Titre</th>
                    <th class="text-left px-4 py-3">Étudiant</th>
                    <th class="text-left px-4 py-3">Année</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($memoires as $memoire)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $memoire->titre }}</td>
                        <td class="px-4 py-3">{{ $memoire->student?->nom }} {{ $memoire->student?->prenom }}</td>
                        <td class="px-4 py-3">{{ $memoire->annee }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('memoires.download', $memoire) }}" class="text-slate-700">PDF</a>
                            <form method="POST" action="{{ route('memoires.destroy', $memoire) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600" onclick="return confirm('Supprimer ce mémoire ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucun mémoire.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
