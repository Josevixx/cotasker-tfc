<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TermsController;

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

    // Rutas de tareas de equipos
    Route::post('/teams/{team}/tasks', [TeamController::class, 'storeTask'])->name('teams.tasks.store');
    Route::get('/teams/{team}/tasks/{task}', [TeamController::class, 'showTask'])->name('teams.tasks.show');
    Route::patch('/teams/{team}/tasks/{task}', [TeamController::class, 'updateTask'])->name('teams.tasks.update');
    Route::delete('/teams/{team}/tasks/{task}', [TeamController::class, 'destroyTask'])->name('teams.tasks.destroy');

    // Rutas de tareas de equipos (acciones)
    Route::patch('/teams/{team}/tasks/{task}/complete', [TeamController::class, 'completeTask'])->name('teams.tasks.complete');
    Route::patch('/teams/{team}/tasks/{task}/uncomplete', [TeamController::class, 'uncompleteTask'])->name('teams.tasks.uncomplete');

    Route::patch('/teams/{team}/tasks/{task}/assign/{user}', [TeamController::class, 'assignTask'])->name('teams.tasks.assign.user');
    Route::patch('/teams/{team}/tasks/{task}/unassign/{user}', [TeamController::class, 'unassignTask'])->name('teams.tasks.unassign.user');
    // Asignar y desasignar tareas a los usuarios (sin especificar usuario)
    Route::patch('/teams/{team}/tasks/{task}/assign', [TeamController::class, 'assignTask'])->name('teams.tasks.assign');
    Route::patch('/teams/{team}/tasks/{task}/unassign', [TeamController::class, 'unassignTask'])->name('teams.tasks.unassign');

    Route::patch('/teams/{team}/tasks/{task}/priority', [TeamController::class, 'setTaskPriority'])->name('teams.tasks.priority');
    Route::patch('/teams/{team}/tasks/{task}/unpriority', [TeamController::class, 'unsetTaskPriority'])->name('teams.tasks.unpriority');

    Route::patch('/teams/{team}/tasks/{task}/due-date', [TeamController::class, 'setTaskDueDate'])->name('teams.tasks.due-date');
    Route::patch('/teams/{team}/tasks/{task}/un-due-date', [TeamController::class, 'unsetTaskDueDate'])->name('teams.tasks.un-due-date');
    
    Route::patch('/teams/{team}/tasks/{task}/status', [TeamController::class, 'setTaskStatus'])->name('teams.tasks.status');

    //Rutas del footer
    Route::get('/terms', [TermsController::class, 'terms'])->name('terms');
    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    Route::get('/privacy', [PrivacyController::class, 'privacy'])->name('privacy');

    // Rutas del perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para cerrar sesión
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
});

require __DIR__ . '/auth.php';
