<?php

namespace App\Http\Controllers;

use App\Models\Memoire;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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

        return Inertia::render('Memoires/Index', [
            'memoires' => $memoires,
            'annee' => $annee,
            'search' => $search,
        ]);
    }

    public function create()
    {
        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();

        return Inertia::render('Memoires/Create', [
            'students' => $students,
        ]);
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

    public function download(Memoire $memoire)
    {
        if (!$memoire->fichier_pdf || !Storage::disk('public')->exists($memoire->fichier_pdf)) {
            abort(404, 'Fichier introuvable.');
        }

        return Storage::disk('public')->download($memoire->fichier_pdf);
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

        return Inertia::render('Memoires/ByStudent', [
            'student' => $student,
            'memoires' => $memoires,
            'annee' => $annee,
        ]);
    }
}
