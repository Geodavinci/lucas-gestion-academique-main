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

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/app', [DashboardController::class, 'index'])->name('app.home');
    Route::get('/mon-dossier', [StudentProfileController::class, 'show'])->name('student.profile');
    Route::get('/mon-dossier/pdf', [StudentProfileController::class, 'pdf'])->name('student.profile.pdf');
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/courses/{course}/grades', [GradeController::class, 'create'])->name('grades.create');
    Route::post('/teacher/courses/{course}/grades', [GradeController::class, 'store'])->name('grades.store');

    
    Route::get('students/{student}/memoires', [MemoireController::class, 'byStudent'])
        ->name('memoires.byStudent');

    Route::get('memoires/{memoire}/download', [MemoireController::class, 'download'])
        ->name('memoires.download');
    Route::get('memoires/{memoire}/download/corrige', [MemoireController::class, 'downloadCorrige'])
        ->name('memoires.download.corrige');

    // Workflow routes
    Route::post('memoires/{memoire}/submit', [MemoireController::class, 'submit'])->name('memoires.submit');
    Route::patch('memoires/{memoire}/request-changes', [MemoireController::class, 'requestChanges'])->name('memoires.requestChanges');
    Route::patch('memoires/{memoire}/approve', [MemoireController::class, 'approve'])->name('memoires.approve');
    Route::patch('memoires/{memoire}/reject', [MemoireController::class, 'reject'])->name('memoires.reject');

    Route::resource('memoires', MemoireController::class)
        ->except(['edit', 'update']);

    Route::resource('teachers', TeacherController::class);
    Route::get('students/{student}/soutenances/create', [SoutenanceController::class, 'createForStudent'])
        ->name('soutenances.createForStudent');
    Route::get('soutenances/export/csv', [SoutenanceController::class, 'exportCsv'])
        ->name('soutenances.export');
    Route::resource('soutenances', SoutenanceController::class);
    Route::get('recu-paiements/{recu_paiement}/download', [RecuPaiementController::class, 'download'])
        ->name('recu-paiements.download');
    Route::get('recu-paiements/export/csv', [RecuPaiementController::class, 'exportCsv'])
        ->name('recu-paiements.export');
    Route::resource('recu-paiements', RecuPaiementController::class);

    // Bulk actions
    Route::post('students/bulk-delete', [StudentController::class, 'bulkDestroy'])->name('students.bulk-destroy');
    Route::post('teachers/bulk-delete', [TeacherController::class, 'bulkDestroy'])->name('teachers.bulk-destroy');
    Route::post('memoires/bulk-delete', [MemoireController::class, 'bulkDestroy'])->name('memoires.bulk-destroy');
    Route::post('soutenances/bulk-delete', [SoutenanceController::class, 'bulkDestroy'])->name('soutenances.bulk-destroy');
    Route::post('recu-paiements/bulk-delete', [RecuPaiementController::class, 'bulkDestroy'])->name('recu-paiements.bulk-destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    Route::get('/notifications/recent', [NotificationController::class, 'recent'])->name('notifications.recent');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::delete('/notifications', [NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');
});

/*
|--------------------------------------------------------------------------
| Dashboard (auth + vérification email)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return app(DashboardController::class)->index();
    }

    return redirect()->route('student.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Routes protégées (utilisateur connecté)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |-------------------------
    | Profil utilisateur
    |-------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |-------------------------
    | Étudiants (CRUD)
    |-------------------------
    */
    Route::resource('students', StudentController::class);

    /*
    |-------------------------
    | Mémoires (consultation)
    |-------------------------
    */
    Route::get('/memoires', [MemoireController::class, 'index'])
        ->name('memoires.index');

    // Mémoires par étudiant
    Route::get('/students/{student}/memoires', [MemoireController::class, 'byStudent'])
        ->name('students.memoires');
});

/*
|--------------------------------------------------------------------------
| Routes ADMIN uniquement
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    // Création des mémoires (réservée à l’admin)
    Route::get('/memoires/create', [MemoireController::class, 'create'])
        ->name('memoires.create');

    Route::post('/memoires', [MemoireController::class, 'store'])
        ->name('memoires.store');

    Route::get('/memoires/{memoire}/edit', [MemoireController::class, 'edit'])
        ->name('memoires.edit');

    Route::match(['put', 'patch'], '/memoires/{memoire}', [MemoireController::class, 'update'])
        ->name('memoires.update');

    Route::patch('/admin/users/{user}/role', [DashboardController::class, 'updateUserRole'])
        ->name('admin.users.role');
    Route::patch('/admin/users/{user}/student', [DashboardController::class, 'linkStudent'])
        ->name('admin.users.student');
    Route::patch('/admin/users/{user}/teacher', [DashboardController::class, 'linkTeacher'])
        ->name('admin.users.teacher');
    Route::post('/admin/courses/assign', [DashboardController::class, 'assignCourseTeacher'])
        ->name('admin.courses.assign');

    Route::resource('filieres', FiliereController::class)->except(['show']);
    Route::resource('courses', CourseController::class)->except(['show']);
    Route::resource('enrollments', EnrollmentController::class)->only(['index', 'create', 'store', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Authentification Breeze
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
