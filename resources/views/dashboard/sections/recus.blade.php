<div class="flex items-center justify-between">
    <h2 class="text-lg font-semibold text-slate-900">Reçus</h2>
    <button type="button" @click="tab = 'overview'" class="text-sm text-slate-600">Retour</button>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Ajouter un reçu</h3>
    </div>
    <div class="{{ $cardBody }}">
        <form method="POST" action="{{ route('recu-paiements.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf
            <input name="numero_recu" placeholder="Numéro reçu" class="rounded-lg border-slate-300" />
            <input name="montant" placeholder="Montant" class="rounded-lg border-slate-300" />
            <input type="date" name="date_paiement" class="rounded-lg border-slate-300" />
            <select name="student_id" class="rounded-lg border-slate-300">
                <option value="">Sélectionner un étudiant</option>
                @foreach ($studentsList as $student)
                    <option value="{{ $student->id }}">{{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})</option>
                @endforeach
            </select>
            <input type="file" name="fichier_pdf" class="rounded-lg border-slate-300 bg-white md:col-span-2" />
            <div class="md:col-span-2">
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm text-white">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<div class="{{ $card }}">
    <div class="{{ $cardHeader }}">
        <h3 class="text-base font-semibold">Liste récente</h3>
        <a href="{{ route('recu-paiements.index') }}" class="text-sm text-slate-600">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-4 py-3">Numéro</th>
                    <th class="text-left px-4 py-3">Étudiant</th>
                    <th class="text-left px-4 py-3">Montant</th>
                    <th class="text-right px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recus as $recu)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $recu->numero_recu }}</td>
                        <td class="px-4 py-3">{{ $recu->student?->nom }} {{ $recu->student?->prenom }}</td>
                        <td class="px-4 py-3">{{ $recu->montant }}</td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('recu-paiements.show', $recu) }}" class="text-slate-700">Voir</a>
                            <a href="{{ route('recu-paiements.edit', $recu) }}" class="text-slate-700">Éditer</a>
                            <form method="POST" action="{{ route('recu-paiements.destroy', $recu) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600" onclick="return confirm('Supprimer ce reçu ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="px-4 py-6 text-center text-slate-500" colspan="4">Aucun reçu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
