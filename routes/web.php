<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\MemoireController;
use App\Http\Controllers\SoutenanceController;
use App\Http\Controllers\RecuPaiementController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\TeacherDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil publique
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Routes accessibles aux utilisateurs connectés
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/app', [DashboardController::class, 'index'])
        ->name('app.home');

    // Espace étudiant
    Route::get('/mon-dossier', [StudentProfileController::class, 'show'])
        ->middleware('role:student')
        ->name('student.profile');

    Route::get('/mon-dossier/pdf', [StudentProfileController::class, 'pdf'])
        ->middleware('role:student')
        ->name('student.profile.pdf');

    // Espace enseignant
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])
        ->middleware('role:teacher')
        ->name('teacher.dashboard');

    Route::get('/teacher/courses/{course}/grades', [GradeController::class, 'create'])
        ->middleware('role:teacher')
        ->name('grades.create');

    Route::post('/teacher/courses/{course}/grades', [GradeController::class, 'store'])
        ->middleware('role:teacher')
        ->name('grades.store');

    // Mémoires par étudiant
    Route::get('students/{student}/memoires', [MemoireController::class, 'byStudent'])
        ->name('memoires.byStudent');

    // Téléchargement des mémoires
    Route::get('memoires/{memoire}/download', [MemoireController::class, 'download'])
        ->name('memoires.download');

    Route::get('memoires/{memoire}/download/corrige', [MemoireController::class, 'downloadCorrige'])
        ->name('memoires.download.corrige');

    // Workflow des mémoires
    Route::post('memoires/{memoire}/submit', [MemoireController::class, 'submit'])
        ->name('memoires.submit');

    Route::patch('memoires/{memoire}/request-changes', [MemoireController::class, 'requestChanges'])
        ->name('memoires.requestChanges');

    Route::patch('memoires/{memoire}/approve', [MemoireController::class, 'approve'])
        ->name('memoires.approve');

    Route::patch('memoires/{memoire}/reject', [MemoireController::class, 'reject'])
        ->name('memoires.reject');

    Route::resource('memoires', MemoireController::class)
        ->except(['edit', 'update']);

    // Soutenances : consultation
    Route::get('soutenances/export/csv', [SoutenanceController::class, 'exportCsv'])
        ->name('soutenances.export');

    Route::get('soutenances', [SoutenanceController::class, 'index'])
        ->name('soutenances.index');

    Route::get('soutenances/{soutenance}', [SoutenanceController::class, 'show'])
        ->whereNumber('soutenance')
        ->name('soutenances.show');

    // Reçus de paiement
    Route::get('recu-paiements/{recu_paiement}/download', [RecuPaiementController::class, 'download'])
        ->name('recu-paiements.download');

    Route::get('recu-paiements/export/csv', [RecuPaiementController::class, 'exportCsv'])
        ->name('recu-paiements.export');

    Route::resource('recu-paiements', RecuPaiementController::class);

    Route::post('recu-paiements/bulk-delete', [RecuPaiementController::class, 'bulkDestroy'])
        ->name('recu-paiements.bulk-destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])
        ->name('notifications.unreadCount');

    Route::get('/notifications/recent', [NotificationController::class, 'recent'])
        ->name('notifications.recent');

    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

    Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])
        ->name('notifications.delete');

    Route::delete('/notifications', [NotificationController::class, 'deleteAll'])
        ->name('notifications.deleteAll');

});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Profil utilisateur
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Consultation des mémoires
    Route::get('/memoires', [MemoireController::class, 'index'])
        ->name('memoires.index');

    Route::get('/students/{student}/memoires', [MemoireController::class, 'byStudent'])
        ->name('students.memoires');

});

/*
|--------------------------------------------------------------------------
| Routes ADMIN uniquement
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // Gestion des étudiants
    Route::resource('students', StudentController::class);

    Route::post('students/bulk-delete', [StudentController::class, 'bulkDestroy'])
        ->name('students.bulk-destroy');

    // Gestion des enseignants
    Route::resource('teachers', TeacherController::class);

    Route::post('teachers/bulk-delete', [TeacherController::class, 'bulkDestroy'])
        ->name('teachers.bulk-destroy');

    // Soutenances
    Route::get('students/{student}/soutenances/create', [SoutenanceController::class, 'createForStudent'])
        ->name('soutenances.createForStudent');

    Route::resource('soutenances', SoutenanceController::class)
        ->except(['index', 'show']);

    Route::post('soutenances/bulk-delete', [SoutenanceController::class, 'bulkDestroy'])
        ->name('soutenances.bulk-destroy');

    // Gestion des mémoires
    Route::get('/memoires/create', [MemoireController::class, 'create'])
        ->name('memoires.create');

    Route::post('/memoires', [MemoireController::class, 'store'])
        ->name('memoires.store');

    // Gestion des utilisateurs
    Route::patch('/admin/users/{user}/role', [DashboardController::class, 'updateUserRole'])
        ->name('admin.users.role');

    Route::patch('/admin/users/{user}/student', [DashboardController::class, 'linkStudent'])
        ->name('admin.users.student');

    Route::patch('/admin/users/{user}/teacher', [DashboardController::class, 'linkTeacher'])
        ->name('admin.users.teacher');

    // Affectation des cours
    Route::post('/admin/courses/assign', [DashboardController::class, 'assignCourseTeacher'])
        ->name('admin.courses.assign');

    // Filières
    Route::resource('filieres', FiliereController::class)
        ->except(['show']);

    // Cours
    Route::resource('courses', CourseController::class)
        ->except(['show']);

    // Inscriptions
    Route::resource('enrollments', EnrollmentController::class)
        ->only(['index', 'create', 'store', 'destroy']);

});

// Modification des mémoires : accès contrôlé par MemoirePolicy
Route::middleware(['auth'])->group(function () {
    Route::get('/memoires/{memoire}/edit', [MemoireController::class, 'edit'])
        ->name('memoires.edit');

    Route::match(['put', 'patch'], '/memoires/{memoire}', [MemoireController::class, 'update'])
        ->name('memoires.update');
});

/*
|--------------------------------------------------------------------------
| Authentification Breeze
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
