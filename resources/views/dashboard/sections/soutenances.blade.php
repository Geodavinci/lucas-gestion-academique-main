<div class="flex items-center justify-between">
    <h2 class="text-lg font-semibold text-slate-900">Soutenances</h2>
    <button type="button" @click="tab = 'overview'" class="text-sm text-slate-600">Retour</button>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Ajouter une soutenance</h3>
    </div>
    <div class="{{ $cardBody }}">
        <form method="POST" action="{{ route('soutenances.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf
            <input type="date" name="date_soutenance" class="rounded-lg border-slate-300" />
            <select name="statut" class="rounded-lg border-slate-300">
                <option value="">Statut</option>
                <option value="Valide">Valide</option>
                <option value="Ajourne">Ajourne</option>
            </select>
            <select name="student_id" class="rounded-lg border-slate-300 md:col-span-2">
                <option value="">Sélectionner un étudiant</option>
                @foreach ($studentsList as $student)
                    <option value="{{ $student->id }}">{{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})</option>
                @endforeach
            </select>
            <select name="directeur_memoire_id" class="rounded-lg border-slate-300">
                <option value="">Directeur mémoire</option>
                @foreach ($teachersList as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->nom }} {{ $teacher->prenom }}</option>
                @endforeach
            </select>
            <select name="evaluateur_id" class="rounded-lg border-slate-300">
                <option value="">Évaluateur</option>
                @foreach ($teachersList as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->nom }} {{ $teacher->prenom }}</option>
                @endforeach
            </select>
            <select name="president_jury_id" class="rounded-lg border-slate-300">
                <option value="">Président jury</option>
                @foreach ($teachersList as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->nom }} {{ $teacher->prenom }}</option>
                @endforeach
            </select>
            <textarea name="description" placeholder="Description" class="rounded-lg border-slate-300 md:col-span-2"></textarea>
            <div class="md:col-span-2">
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Liste récente</h3>
        <a href="{{ route('soutenances.index') }}" class="text-sm text-slate-600">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-4 py-3">Date</th>
                    <th class="text-left px-4 py-3">Étudiant</th>
                    <th class="text-left px-4 py-3">Statut</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($soutenances as $soutenance)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $soutenance->date_soutenance }}</td>
                        <td class="px-4 py-3">{{ $soutenance->student?->nom }} {{ $soutenance->student?->prenom }}</td>
                        <td class="px-4 py-3">{{ $soutenance->statut }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('soutenances.show', $soutenance) }}" class="text-slate-700">Voir</a>
                            <a href="{{ route('soutenances.edit', $soutenance) }}" class="text-slate-700">Éditer</a>
                            <form method="POST" action="{{ route('soutenances.destroy', $soutenance) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600" onclick="return confirm('Supprimer cette soutenance ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucune soutenance.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
