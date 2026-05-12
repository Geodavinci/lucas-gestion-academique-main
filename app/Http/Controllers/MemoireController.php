<?php

namespace App\Http\Controllers;

use App\Models\Memoire;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemoireController extends Controller
{
    public function index(Request $request)
    {
        $annee = $request->query('annee');
        $search = $request->query('q');

        $memoiresQuery = Memoire::with('student')
            ->when($search, function ($query) use ($search) {
                $query->where('titre', 'like', '%' . $search . '%');
            })
            ->orderByDesc('annee');

        if ($annee) {
            $memoiresQuery->where('annee', $annee);
        }

        $memoires = $memoiresQuery->paginate(10)->withQueryString();

        return view('memoires.index', compact('memoires', 'annee', 'search'));
    }

    public function create()
    {
        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('memoires.create', compact('students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'annee' => 'required|digits:4|integer|min:1900|max:2100',
            'fichier_pdf' => 'required|file|mimes:pdf|max:10240',
            'student_id' => 'required|exists:students,id',
        ]);

        $path = $request->file('fichier_pdf')->store('memoires', 'public');
        $data['fichier_pdf'] = $path;

        Memoire::create($data);

        return redirect()->route('memoires.index')
            ->with('success', 'Memoire ajoute avec succes.');
    }

    public function edit(Memoire $memoire)
    {
        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('memoires.edit', compact('memoire', 'students'));
    }

    public function update(Request $request, Memoire $memoire)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'annee' => 'required|digits:4|integer|min:1900|max:2100',
            'student_id' => 'required|exists:students,id',
            'fichier_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'fichier_pdf_corrige' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('fichier_pdf')) {
            if ($memoire->fichier_pdf && Storage::disk('public')->exists($memoire->fichier_pdf)) {
                Storage::disk('public')->delete($memoire->fichier_pdf);
            }
            $data['fichier_pdf'] = $request->file('fichier_pdf')->store('memoires', 'public');
        }

        if ($request->hasFile('fichier_pdf_corrige')) {
            if ($memoire->fichier_pdf_corrige && Storage::disk('public')->exists($memoire->fichier_pdf_corrige)) {
                Storage::disk('public')->delete($memoire->fichier_pdf_corrige);
            }
            $data['fichier_pdf_corrige'] = $request->file('fichier_pdf_corrige')->store('memoires/corriges', 'public');
        }

        $memoire->update($data);

        return redirect()->route('memoires.index')
            ->with('success', 'Memoire mis a jour avec succes.');
    }

    public function download(Memoire $memoire)
    {
        if (!$memoire->fichier_pdf || !Storage::disk('public')->exists($memoire->fichier_pdf)) {
            return redirect()->back()->withErrors(['fichier_pdf' => 'Aucun fichier PDF disponible pour ce mémoir.']);
        }

        return Storage::disk('public')->download($memoire->fichier_pdf);
    }

    public function downloadCorrige(Memoire $memoire)
    {
        if (!$memoire->fichier_pdf_corrige || !Storage::disk('public')->exists($memoire->fichier_pdf_corrige)) {
            return redirect()->back()->withErrors(['fichier_pdf_corrige' => 'Aucun fichier PDF corrigé disponible pour ce mémoir.']);
        }

        return Storage::disk('public')->download($memoire->fichier_pdf_corrige);
    }

    public function destroy(Memoire $memoire)
    {
        if ($memoire->fichier_pdf && Storage::disk('public')->exists($memoire->fichier_pdf)) {
            Storage::disk('public')->delete($memoire->fichier_pdf);
        }

        $memoire->delete();

        return redirect()->route('memoires.index')
            ->with('success', 'Memoire supprime.');
    }

    public function byStudent(Request $request, Student $student)
    {
        $annee = $request->query('annee');

        $memoiresQuery = $student->memoires()->orderByDesc('annee');
        if ($annee) {
            $memoiresQuery->where('annee', $annee);
        }

        $memoires = $memoiresQuery->get();

        return view('memoires.by-student', compact('student', 'memoires', 'annee'));
    }
}
