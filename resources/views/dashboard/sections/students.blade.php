<div class="flex items-center justify-between">
    <h2 class="text-lg font-semibold text-slate-900">Étudiants</h2>
    <button type="button" @click="tab = 'overview'" class="text-sm text-slate-600">Retour</button>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Ajouter un étudiant</h3>
    </div>
    <div class="{{ $cardBody }}">
        <form method="POST" action="{{ route('students.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf
            <input name="matricule" placeholder="Matricule" class="rounded-lg border-slate-300" />
            <input name="nom" placeholder="Nom" class="rounded-lg border-slate-300" />
            <input name="prenom" placeholder="Prénom" class="rounded-lg border-slate-300" />
            <input name="email" placeholder="Email" class="rounded-lg border-slate-300" />
            <input name="telephone" placeholder="Téléphone" class="rounded-lg border-slate-300" />
            <input name="filiere" placeholder="Filière" class="rounded-lg border-slate-300" />
            <input name="niveau" placeholder="Niveau" class="rounded-lg border-slate-300" />
            <div class="md:col-span-2">
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Liste récente</h3>
        <a href="{{ route('students.index') }}" class="text-sm text-slate-600">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-4 py-3">Matricule</th>
                    <th class="text-left px-4 py-3">Nom</th>
                    <th class="text-left px-4 py-3">Filière</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $student->matricule }}</td>
                        <td class="px-4 py-3">{{ $student->nom }} {{ $student->prenom }}</td>
                        <td class="px-4 py-3">{{ $student->filiere }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('students.show', $student) }}" class="text-slate-700">Voir</a>
                            <a href="{{ route('students.edit', $student) }}" class="text-slate-700">Éditer</a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600" onclick="return confirm('Supprimer cet étudiant ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucun étudiant.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
