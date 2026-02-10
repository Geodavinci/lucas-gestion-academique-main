<?php

namespace App\Http\Controllers;

use App\Models\RecuPaiement;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecuPaiementController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->query('q');
        $date = $request->query('date');

        $recus = RecuPaiement::with('student')
            ->when($search, function ($query) use ($search) {
                $query->where('numero_recu', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function ($q) use ($search) {
                        $q->where('nom', 'like', '%' . $search . '%')
                          ->orWhere('prenom', 'like', '%' . $search . '%')
                          ->orWhere('matricule', 'like', '%' . $search . '%');
                    });
            })
            ->when($date, fn($q) => $q->where('date_paiement', $date))
            ->orderByDesc('date_paiement')
            ->paginate(10)
            ->withQueryString();

        return view('recu_paiements.index', compact('recus', 'search', 'date'));
    }

    public function create()
    {
        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('recu_paiements.create', compact('students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero_recu' => 'required|string|max:100|unique:recu_paiements,numero_recu',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'fichier_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'student_id' => 'required|exists:students,id',
        ]);

        if ($request->hasFile('fichier_pdf')) {
            $data['fichier_pdf'] = $request->file('fichier_pdf')->store('recus', 'public');
        }

        RecuPaiement::create($data);

        return redirect()->route('recu-paiements.index')
            ->with('success', 'Recu ajoute avec succes.');
    }


    public function exportCsv(\Illuminate\Http\Request $request)
    {
        $search = $request->query('q');
        $date = $request->query('date');

        $rows = \App\Models\RecuPaiement::with('student')
            ->when($search, function ($query) use ($search) {
                $query->where('numero_recu', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function ($q) use ($search) {
                        $q->where('nom', 'like', '%' . $search . '%')
                          ->orWhere('prenom', 'like', '%' . $search . '%')
                          ->orWhere('matricule', 'like', '%' . $search . '%');
                    });
            })
            ->when($date, fn($q) => $q->where('date_paiement', $date))
            ->orderByDesc('date_paiement')
            ->get();

        $filename = 'recus-' . date('Ymd-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Numero recu', 'Etudiant', 'Matricule', 'Montant', 'Date']);
            foreach ($rows as $recu) {
                fputcsv($out, [
                    $recu->numero_recu,
                    optional($recu->student)->nom . ' ' . optional($recu->student)->prenom,
                    optional($recu->student)->matricule,
                    $recu->montant,
                    $recu->date_paiement,
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function show(RecuPaiement $recu_paiement)
    {
        return view('recu_paiements.show', ['recu' => $recu_paiement]);
    }

    public function edit(RecuPaiement $recu_paiement)
    {
        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('recu_paiements.edit', ['recu' => $recu_paiement, 'students' => $students]);
    }

    public function update(Request $request, RecuPaiement $recu_paiement)
    {
        $data = $request->validate([
            'numero_recu' => 'required|string|max:100|unique:recu_paiements,numero_recu,' . $recu_paiement->id,
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'fichier_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'student_id' => 'required|exists:students,id',
        ]);

        if ($request->hasFile('fichier_pdf')) {
            if ($recu_paiement->fichier_pdf && Storage::disk('public')->exists($recu_paiement->fichier_pdf)) {
                Storage::disk('public')->delete($recu_paiement->fichier_pdf);
            }
            $data['fichier_pdf'] = $request->file('fichier_pdf')->store('recus', 'public');
        }

        $recu_paiement->update($data);

        return redirect()->route('recu-paiements.show', $recu_paiement)
            ->with('success', 'Recu mis a jour.');
    }

    public function download(RecuPaiement $recu_paiement)
    {
        if (!$recu_paiement->fichier_pdf) {
            return redirect()->back()->withErrors(['fichier_pdf' => 'Aucun fichier disponible.']);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($recu_paiement->fichier_pdf);
    }

    public function destroy(RecuPaiement $recu_paiement)
    {
        if ($recu_paiement->fichier_pdf && Storage::disk('public')->exists($recu_paiement->fichier_pdf)) {
            Storage::disk('public')->delete($recu_paiement->fichier_pdf);
        }

        $recu_paiement->delete();

        return redirect()->route('recu-paiements.index')
            ->with('success', 'Recu supprime.');
    }
}
