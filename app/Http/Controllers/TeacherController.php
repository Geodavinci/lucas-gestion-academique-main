<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->query('q');

        $teachers = Teacher::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', '%' . $search . '%')
                      ->orWhere('prenom', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('specialite', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(10)
            ->withQueryString();

        return view('teachers.index', compact('teachers', 'search'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:teachers,email',
            'telephone' => 'nullable|string|max:30',
            'specialite' => 'required|string|max:150',
        ]);

        Teacher::create($data);

        return redirect()->route('teachers.index')
            ->with('success', 'Enseignant ajoute avec succes.');
    }

    public function show(Teacher $teacher)
    {
        $soutenances = \App\Models\Soutenance::with('student')
            ->where('directeur_memoire_id', $teacher->id)
            ->orWhere('evaluateur_id', $teacher->id)
            ->orWhere('president_jury_id', $teacher->id)
            ->orderByDesc('date_soutenance')
            ->get();

        return view('teachers.show', compact('teacher', 'soutenances'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:teachers,email,' . $teacher->id,
            'telephone' => 'nullable|string|max:30',
            'specialite' => 'required|string|max:150',
        ]);

        $teacher->update($data);

        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'Enseignant mis a jour.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Enseignant supprime.');
    }
}
