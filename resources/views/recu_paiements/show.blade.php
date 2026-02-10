@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-semibold">Recu {{ $recu->numero_recu }}</h1>
        <p class="text-sm text-slate-600">Date: {{ $recu->date_paiement }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('recu-paiements.edit', $recu) }}" class="rounded border border-slate-300 px-4 py-2 text-sm">Modifier</a>
        <a href="{{ route('recu-paiements.index') }}" class="rounded border border-slate-300 px-4 py-2 text-sm">Retour</a>
    </div>
</div>

<div class="bg-white rounded border border-slate-200 shadow-sm p-6">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <dt class="text-slate-500">Etudiant</dt>
            <dd class="font-medium">{{ $recu->student?->nom }} {{ $recu->student?->prenom }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Montant</dt>
            <dd class="font-medium">{{ number_format($recu->montant, 2, '.', ' ') }}</dd>
        </div>
        <div>
            <dt class="text-slate-500">Fichier</dt>
            <dd class="font-medium">
                @if ($recu->fichier_pdf)
                    <a class="underline" href="{{ route('recu-paiements.download', $recu) }}" target="_blank">Voir PDF</a>
                @else
                    -
                @endif
            </dd>
        </div>
    </dl>
</div>
@endsection
