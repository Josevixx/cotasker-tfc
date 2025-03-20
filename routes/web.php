<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Ruta para almacenar un nuevo equipo
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    
    // Ruta para acceder al dashboard, que llama al método 'index' de TeamController
    Route::get('/dashboard', [TeamController::class, 'index'])->name('dashboard.index');
    
    // Ruta para cerrar sesión
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
});

// Rutas del perfil de usuario (opcional)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
