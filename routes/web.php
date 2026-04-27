<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    UserController,
    CourseController,
    CourseCallController,
    CourseAssignmentController,
    NotificationController,
    AdminPanelController,
    DashboardController
};

/*
|--------------------------------------------------------------------------
| PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| DASHBOARD USUARIO
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/history', [DashboardController::class, 'history'])
        ->name('dashboard.history');

    /*
    |--------------------------------------------------------------------------
    | PERFIL
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Panel admin
        Route::get('/panel', [AdminPanelController::class, 'index'])
            ->name('admin.panel');

        // =====================
        // USUARIOS
        // =====================
        Route::resource('users', UserController::class);

        Route::patch('users/{id}/toggle-active', [UserController::class, 'toggleActive'])
        ->name('users.toggleActive');
        
        Route::get('users/export/csv', [UserController::class, 'exportCsv'])
            ->name('users.export.csv');

        Route::get('users/export/excel', [UserController::class, 'exportExcel'])
            ->name('users.export.excel');

        // =====================
        // CURSOS
        // =====================
        Route::resource('courses', CourseController::class);

        // =====================
        // CONVOCATORIAS
        // =====================
        Route::resource('course-calls', CourseCallController::class);

        // =====================
        // ASIGNACIONES
        // =====================
        Route::resource('assignments', CourseAssignmentController::class);

        Route::post('assignments/{id}/notify', [CourseAssignmentController::class, 'notify'])
            ->name('assignments.notify');

        // =====================
        // NOTIFICACIONES
        // =====================
        Route::get('notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        Route::post('send-course-notifications', [NotificationController::class, 'sendCourseNotifications'])
            ->name('admin.sendCourseNotifications');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

