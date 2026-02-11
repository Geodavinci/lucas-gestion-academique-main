<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminGradeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MemoireController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecuPaiementController;
use App\Http\Controllers\SoutenanceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Landing (Inertia)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('landing');

// Auth Breeze (routes dans routes/auth.php)

// Dashboard (redirige selon rôle)
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return app(DashboardController::class)->index();
    }
    if ($user && $user->role === 'teacher') {
        return redirect()->route('teacher.dashboard');
    }
    return redirect()->route('student.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/app', [DashboardController::class, 'index'])->name('app.home');

    Route::get('/mon-dossier', [StudentProfileController::class, 'show'])->name('student.profile');
    Route::get('/mon-dossier/pdf', [StudentProfileController::class, 'pdf'])->name('student.profile.pdf');

    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/courses/{course}/grades', [GradeController::class, 'create'])->name('grades.create');
    Route::post('/teacher/courses/{course}/grades', [GradeController::class, 'store'])->name('grades.store');

    Route::get('students/{student}/memoires', [MemoireController::class, 'byStudent'])->name('students.memoires');

    Route::get('memoires/{memoire}/download', [MemoireController::class, 'download'])->name('memoires.download');
    Route::resource('memoires', MemoireController::class)->except(['show', 'edit', 'update']);

    Route::resource('teachers', TeacherController::class);
    Route::get('students/{student}/soutenances/create', [SoutenanceController::class, 'createForStudent'])
        ->name('soutenances.createForStudent');
    Route::get('soutenances/export/csv', [SoutenanceController::class, 'exportCsv'])->name('soutenances.export');
    Route::resource('soutenances', SoutenanceController::class);

    Route::get('recu-paiements/{recu_paiement}/download', [RecuPaiementController::class, 'download'])
        ->name('recu-paiements.download');
    Route::get('recu-paiements/export/csv', [RecuPaiementController::class, 'exportCsv'])
        ->name('recu-paiements.export');
    Route::resource('recu-paiements', RecuPaiementController::class);

    Route::resource('students', StudentController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('filieres', FiliereController::class)->except(['show']);
    Route::resource('courses', CourseController::class)->except(['show']);
    Route::resource('enrollments', EnrollmentController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::patch('/admin/users/{user}/role', [DashboardController::class, 'updateUserRole'])->name('admin.users.role');
    Route::patch('/admin/users/{user}/student', [DashboardController::class, 'linkStudent'])->name('admin.users.student');
    Route::patch('/admin/users/{user}/teacher', [DashboardController::class, 'linkTeacher'])->name('admin.users.teacher');
    Route::post('/admin/courses/assign', [DashboardController::class, 'assignCourseTeacher'])->name('admin.courses.assign');
    Route::get('/admin/grades', [AdminGradeController::class, 'index'])->name('admin.grades.index');
});

require __DIR__ . '/auth.php';
