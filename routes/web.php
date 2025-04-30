<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamBoardController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TaskListController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    // Ruta para el dashboard
    Route::get('/dashboard', [TeamController::class, 'index'])->name('dashboard');

    // Rutas de equipos
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::post('/teams/join', [TeamController::class, 'join'])->name('teams.join');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::delete('/teams/{team}/kick/{user}', [TeamController::class, 'kick'])->name('teams.kick');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    Route::delete('/teams/{team}/leave', [TeamController::class, 'leave'])->name('teams.leave');

    // Vista principal del tablero de tareas del equipo
    Route::get('/teams/{team}/board', [TeamBoardController::class, 'index'])->name('teams.board');
    Route::post('/tasks/{task}/move', [TaskController::class, 'move'])->name('tasks.move');
    Route::post('/teams/{team}/task-lists', [TaskListController::class, 'store'])->name('task-lists.store');

    // CRUD de tareas
    Route::post('/teams/{team}/tasks', [TeamBoardController::class, 'storeTask'])->name('teams.tasks.store');
    Route::get('/teams/{team}/tasks/{task}', [TeamBoardController::class, 'showTask'])->name('teams.tasks.show');
    Route::patch('/teams/{team}/tasks/{task}', [TeamBoardController::class, 'updateTask'])->name('teams.tasks.update');
    Route::delete('/teams/{team}/tasks/{task}', [TeamBoardController::class, 'destroyTask'])->name('teams.tasks.destroy');

    // Estado de finalización
    Route::patch('/teams/{team}/tasks/{task}/complete', [TeamBoardController::class, 'completeTask'])->name('teams.tasks.complete');
    Route::patch('/teams/{team}/tasks/{task}/uncomplete', [TeamBoardController::class, 'uncompleteTask'])->name('teams.tasks.uncomplete');

    // Asignación de usuario
    Route::patch('/teams/{team}/tasks/{task}/assign/{user}', [TeamBoardController::class, 'assignTask'])->name('teams.tasks.assign.user');
    Route::patch('/teams/{team}/tasks/{task}/unassign/{user}', [TeamBoardController::class, 'unassignTask'])->name('teams.tasks.unassign.user');
    Route::patch('/teams/{team}/tasks/{task}/assign', [TeamBoardController::class, 'assignTask'])->name('teams.tasks.assign');
    Route::patch('/teams/{team}/tasks/{task}/unassign', [TeamBoardController::class, 'unassignTask'])->name('teams.tasks.unassign');

    // Prioridad
    Route::patch('/teams/{team}/tasks/{task}/priority', [TeamBoardController::class, 'setTaskPriority'])->name('teams.tasks.priority');
    Route::patch('/teams/{team}/tasks/{task}/unpriority', [TeamBoardController::class, 'unsetTaskPriority'])->name('teams.tasks.unpriority');

    // Fechas de vencimiento
    Route::patch('/teams/{team}/tasks/{task}/due-date', [TeamBoardController::class, 'setTaskDueDate'])->name('teams.tasks.due-date');
    Route::patch('/teams/{team}/tasks/{task}/un-due-date', [TeamBoardController::class, 'unsetTaskDueDate'])->name('teams.tasks.un-due-date');

    // Cambiar estado
    Route::patch('/teams/{team}/tasks/{task}/status', [TeamBoardController::class, 'setTaskStatus'])->name('teams.tasks.status');

    //Rutas del footer
    Route::get('/terms', [TermsController::class, 'terms'])->name('terms');
    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    Route::get('/privacy', [PrivacyController::class, 'privacy'])->name('privacy');

    // Rutas del perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para cerrar sesión
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__ . '/auth.php';
