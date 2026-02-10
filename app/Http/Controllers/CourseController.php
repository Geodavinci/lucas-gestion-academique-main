<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Filiere;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('filiere')->orderBy('nom')->get();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $filieres = Filiere::orderBy('nom')->get();

        $teachers = \App\Models\Teacher::orderBy('nom')->orderBy('prenom')->get();

        return view('courses.create', compact('filieres', 'teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'nom' => 'required|string|max:150',
            'code' => 'required|string|max:20|unique:courses,code',
            'coefficient' => 'required|integer|min:1|max:20',
            'semestre' => 'nullable|string|max:50',
        ]);

        $course = Course::create($data);
        $course->teachers()->sync($request->input('teacher_ids', []));

        return redirect()->route('courses.index')->with('success', 'Cours ajoute.');
    }

    public function edit(Course $course)
    {
        $filieres = Filiere::orderBy('nom')->get();

        $teachers = \App\Models\Teacher::orderBy('nom')->orderBy('prenom')->get();

        return view('courses.edit', compact('course', 'filieres', 'teachers'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'filiere_id' => 'required|exists:filieres,id',
            'nom' => 'required|string|max:150',
            'code' => 'required|string|max:20|unique:courses,code,' . $course->id,
            'coefficient' => 'required|integer|min:1|max:20',
            'semestre' => 'nullable|string|max:50',
        ]);

        $course->update($data);
        $course->teachers()->sync($request->input('teacher_ids', []));

        return redirect()->route('courses.index')->with('success', 'Cours mis a jour.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Cours supprime.');
    }
}
