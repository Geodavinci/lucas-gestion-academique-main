<div class="flex items-center justify-between">
    <h2 class="text-lg font-semibold text-slate-900">Enseignants</h2>
    <button type="button" @click="tab = 'overview'" class="text-sm text-slate-600">Retour</button>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Ajouter un enseignant</h3>
    </div>
    <div class="{{ $cardBody }}">
        <form method="POST" action="{{ route('teachers.store') }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf
            <input name="nom" placeholder="Nom" class="rounded-lg border-slate-300" />
            <input name="prenom" placeholder="Prénom" class="rounded-lg border-slate-300" />
            <input name="email" placeholder="Email" class="rounded-lg border-slate-300" />
            <input name="telephone" placeholder="Téléphone" class="rounded-lg border-slate-300" />
            <input name="specialite" placeholder="Spécialité" class="rounded-lg border-slate-300" />
            <div class="md:col-span-2">
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Liste récente</h3>
        <a href="{{ route('teachers.index') }}" class="text-sm text-slate-600">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-4 py-3">Nom</th>
                    <th class="text-left px-4 py-3">Spécialité</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($teachers as $teacher)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $teacher->nom }} {{ $teacher->prenom }}</td>
                        <td class="px-4 py-3">{{ $teacher->specialite }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('teachers.show', $teacher) }}" class="text-slate-700">Voir</a>
                            <a href="{{ route('teachers.edit', $teacher) }}" class="text-slate-700">Éditer</a>
                            <form method="POST" action="{{ route('teachers.destroy', $teacher) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600" onclick="return confirm('Supprimer cet enseignant ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="px-4 py-6 text-center text-slate-500" colspan="3">Aucun enseignant.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
