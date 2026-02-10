<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function create(Request $request, Course $course)
    {
        $user = $request->user();
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Acces reserve aux enseignants');
        }

        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        if (!$course->teachers()->where('teachers.id', $teacher->id)->exists()) {
            abort(403, 'Ce cours ne vous est pas assigne.');
        }

        $students = Enrollment::with('student')
            ->where('filiere_id', $course->filiere_id)
            ->orderByDesc('created_at')
            ->get()
            ->pluck('student')
            ->unique('id')
            ->values();

        $existingGrades = Grade::where('course_id', $course->id)
            ->where('teacher_id', $teacher->id)
            ->get()
            ->keyBy(fn ($g) => $g->student_id . '|' . $g->session);

        return view('grades.create', compact('course', 'students', 'existingGrades'));
    }

    public function store(Request $request, Course $course)
    {
        $user = $request->user();
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Acces reserve aux enseignants');
        }

        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        if (!$course->teachers()->where('teachers.id', $teacher->id)->exists()) {
            abort(403, 'Ce cours ne vous est pas assigne.');
        }

        $data = $request->validate([
            'session' => 'required|in:normal,rattrapage',
            'grades' => 'required|array',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.note' => 'nullable|numeric|min:0|max:20',
        ]);

        foreach ($data['grades'] as $row) {
            if ($row['note'] === null || $row['note'] === '') {
                continue;
            }

            Grade::updateOrCreate(
                [
                    'student_id' => $row['student_id'],
                    'course_id' => $course->id,
                    'session' => $data['session'],
                ],
                [
                    'teacher_id' => $teacher->id,
                    'note' => $row['note'],
                    'date_saisie' => now()->toDateString(),
                ]
            );
        }

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Notes enregistrees.');
    }
}
