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
        $this->authorize('viewAny', Memoire::class);

        $annee = $request->query('annee');
        $search = $request->query('q');

        $memoiresQuery = Memoire::with('student')
            ->when($search, function ($query) use ($search) {
                $query->where('titre', 'like', '%' . $search . '%');
            })
            ->when($annee, function ($query) use ($annee) {
                $query->where('annee', $annee);
            })
            ->orderByDesc('annee');

        $user = $request->user();

        if ($user->role === 'student') {
            $student = $user->student;

            if (!$student) {
                abort(403, 'Aucun dossier étudiant associé à ce compte.');
            }

            $memoiresQuery->where('student_id', $student->id);
        }

        $memoires = $memoiresQuery->paginate(10)->withQueryString();

        return view('memoires.index', compact('memoires', 'annee', 'search'));
    }

    public function create()
    {
        $this->authorize('create', Memoire::class);

        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('memoires.create', compact('students'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Memoire::class);

        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'annee' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . now()->year],
            'fichier_pdf' => 'required|file|mimes:pdf|max:10240',
            'student_id' => 'required|exists:students,id',
        ], [
            'annee.max' => "L'année d'un mémoire déjà soutenu ne peut pas être future.",
        ]);

        $path = $request->file('fichier_pdf')->store('memoires', 'public');
        $data['fichier_pdf'] = $path;

        Memoire::create($data);

        return redirect()->route('memoires.index')
            ->with('success', 'Memoire ajoute avec succes.');
    }

    public function edit(Memoire $memoire)
    {
        $this->authorize('update', $memoire);

        $students = Student::query()->orderBy('nom')->orderBy('prenom')->get();

        return view('memoires.edit', compact('memoire', 'students'));
    }

    public function update(Request $request, Memoire $memoire)
    {
        $this->authorize('update', $memoire);

        $rules = [
            'titre' => 'required|string|max:255',
            'annee' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . now()->year],
            'fichier_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ];

        if ($request->user()->role === 'admin') {
            $rules['student_id'] = 'required|exists:students,id';
            $rules['fichier_pdf_corrige'] = 'nullable|file|mimes:pdf|max:10240';
        } else {
            $rules['fichier_pdf_corrige'] = 'prohibited';
        }

        $data = $request->validate($rules, [
            'annee.max' => "L'année d'un mémoire déjà soutenu ne peut pas être future.",
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
        $this->authorize('view', $memoire);

        if (!$memoire->fichier_pdf || !Storage::disk('public')->exists($memoire->fichier_pdf)) {
            return redirect()->back()->withErrors(['fichier_pdf' => 'Aucun fichier PDF disponible pour ce mémoire.']);
        }

        return Storage::disk('public')->download($memoire->fichier_pdf);
    }

    public function downloadCorrige(Memoire $memoire)
    {
        $this->authorize('view', $memoire);

        if (!$memoire->fichier_pdf_corrige || !Storage::disk('public')->exists($memoire->fichier_pdf_corrige)) {
            return redirect()->back()->withErrors(['fichier_pdf_corrige' => 'Aucun fichier PDF corrigé disponible pour ce mémoire.']);
        }

        return Storage::disk('public')->download($memoire->fichier_pdf_corrige);
    }

    public function destroy(Memoire $memoire)
    {
        $this->authorize('delete', $memoire);

        if ($memoire->fichier_pdf && Storage::disk('public')->exists($memoire->fichier_pdf)) {
            Storage::disk('public')->delete($memoire->fichier_pdf);
        }

        $memoire->delete();

        return redirect()->route('memoires.index')
            ->with('success', 'Memoire supprime.');
    }

    public function byStudent(Request $request, Student $student)
    {
        $user = $request->user();

        if (
            $user->role !== 'admin'
            && !($user->role === 'student' && $user->student?->id === $student->id)
        ) {
            abort(403, 'Accès non autorisé à ces mémoires.');
        }

        $annee = $request->query('annee');

        $memoiresQuery = $student->memoires()->orderByDesc('annee');
        if ($annee) {
            $memoiresQuery->where('annee', $annee);
        }

        $memoires = $memoiresQuery->get();

        return view('memoires.by-student', compact('student', 'memoires', 'annee'));
    }

    public function show(Memoire $memoire)
    {
        $this->authorize('view', $memoire);

        return view('memoires.show', compact('memoire'));
    }

    public function submit(Memoire $memoire)
    {
        $this->authorize('submit', $memoire);

        if (!$memoire->canBeEdited()) {
            return back()->withErrors(['message' => 'Ce mémoire ne peut pas être soumis.']);
        }

        $memoire->submit();

        return back()->with('success', 'Mémoire soumis avec succès.');
    }

    public function review(Memoire $memoire)
    {
        $this->authorize('review', $memoire);

        $memoire->markUnderReview();

        return view('memoires.review', compact('memoire'));
    }

    public function requestChanges(Request $request, Memoire $memoire)
    {
        $this->authorize('requestChanges', $memoire);

        $validated = $request->validate([
            'review_notes' => 'required|string|min:10',
        ]);

        $memoire->requestChanges($validated['review_notes']);

        return redirect()->route('memoires.index')
            ->with('success', 'Corrections demandées. L\'étudiant sera notifié.');
    }

    public function approve(Memoire $memoire)
    {
        $this->authorize('approve', $memoire);

        $memoire->approve();

        return redirect()->route('memoires.index')
            ->with('success', 'Mémoire approuvé avec succès.');
    }

    public function reject(Request $request, Memoire $memoire)
    {
        $this->authorize('reject', $memoire);

        $validated = $request->validate([
            'reason' => 'required|string|min:10',
        ]);

        $memoire->reject($validated['reason']);

        return redirect()->route('memoires.index')
            ->with('success', 'Mémoire rejeté.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:memoires,id'
        ])['ids'];

        Memoire::whereIn('id', $ids)->delete();

        $count = count($ids);
        return redirect()->route('memoires.index')
            ->with('success', "$count mémoire(s) supprimé(s) avec succès.");
    }
}
