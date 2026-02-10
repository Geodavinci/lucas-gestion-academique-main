<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Acces reserve aux enseignants');
        }

        $teacher = Teacher::with('courses.filiere')
            ->where('user_id', $user->id)
            ->first();

        return view('teachers.dashboard', compact('teacher'));
    }
}
