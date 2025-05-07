<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index($teamId)
    {
        $team = Team::findOrFail($teamId);

        // Verifica que el usuario es miembro del equipo
        if (!$team->users->contains(Auth::id()) && $team->owner_id !== Auth::id()) {
            abort(403, 'No tienes acceso a este equipo');
        }

        // Obtener tareas con fecha (due_date) del equipo
        $tasks = $team->tasks()
            ->whereNotNull('due_date')
            ->get();

        return view('calendar', compact('team', 'tasks'));
    }
}
