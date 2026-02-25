<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::with('teachers')->get();
        if ($courses->isEmpty()) {
            return;
        }

        foreach ($courses as $course) {
            $teacher = $course->teachers->first() ?? Teacher::first();
            if (!$teacher) {
                continue;
            }

            $students = Enrollment::where('filiere_id', $course->filiere_id)
                ->with('student')
                ->get()
                ->pluck('student')
                ->unique('id')
                ->values();

            $i = 0;
            foreach ($students as $student) {
                $note = 10 + ($i % 11); // 10..20

                Grade::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'session' => 'normal',
                    ],
                    [
                        'teacher_id' => $teacher->id,
                        'note' => $note,
                        'date_saisie' => now()->toDateString(),
                    ]
                );

                $i++;
            }
        }
    }
}
