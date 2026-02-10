<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    /**
     * Afficher la liste des étudiants
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $filiere = $request->query('filiere');
        $niveau = $request->query('niveau');
        $matricule = $request->query('matricule');

        $students = Student::query()
            ->when($filiere, fn($q) => $q->where('filiere', 'like', '%' . $filiere . '%'))
            ->when($niveau, fn($q) => $q->where('niveau', 'like', '%' . $niveau . '%'))
            ->when($matricule, fn($q) => $q->where('matricule', 'like', '%' . $matricule . '%'))
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students', 'filiere', 'niveau', 'matricule'));
    }

    public function create()
    {
        return view('students.create');
    }

    /**
     * Enregistrer un nouvel étudiant
     */
    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|string|max:50|unique:students,matricule',
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'email'     => 'required|email|unique:students,email',
            'telephone' => 'nullable|string|max:20',
            'filiere'   => 'required|string|max:100',
            'niveau'    => 'required|string|max:50',
        ]);

        Student::create([
            'matricule' => $request->matricule,
            'nom'       => $request->nom,
            'prenom'    => $request->prenom,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'filiere'   => $request->filiere,
            'niveau'    => $request->niveau,
        ]);

        return redirect()->route('students.index')
                         ->with('success', 'Étudiant enregistré avec succès.');
    }

    /**
     * Afficher les détails d'un étudiant
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Mettre à jour les informations d'un étudiant
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'matricule' => 'required|string|max:50|unique:students,matricule,' . $student->id,
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'email'     => 'required|email|unique:students,email,' . $student->id,
            'telephone' => 'nullable|string|max:20',
            'filiere'   => 'required|string|max:100',
            'niveau'    => 'required|string|max:50',
        ]);

        $student->update([
            'matricule' => $request->matricule,
            'nom'       => $request->nom,
            'prenom'    => $request->prenom,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'filiere'   => $request->filiere,
            'niveau'    => $request->niveau,
        ]);

        return redirect()->route('students.index')
                         ->with('success', 'Informations mises à jour avec succès.');
    }

    /**
     * Supprimer un étudiant
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')
                         ->with('success', 'Étudiant supprimé avec succès.');
    }
}
