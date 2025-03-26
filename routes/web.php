<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas protegidas por autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    // Ruta para el dashboard donde se muestran los equipos
    Route::get('/dashboard', [TeamController::class, 'index'])->name('dashboard');

    // Ruta para crear un nuevo equipo
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');

    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

    // Ruta para expulsar un miembro del equipo
    Route::delete('/teams/{team}/kick/{user}', [TeamController::class, 'kick'])->name('teams.kick');

    // Ruta para cerrar sesión
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
});

// Ruta para unirse a un equipo
Route::post('/teams/join', [TeamController::class, 'join'])->name('teams.join');

// Rutas del perfil de usuario (opcional)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

