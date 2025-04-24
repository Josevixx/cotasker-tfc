<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TaskList;
use App\Models\Task;

class TeamBoardController extends Controller
{
    public function index($teamId)
    {
        $team = Team::findOrFail($teamId);

        // Comprobar si el usuario pertenece al equipo
        if (!$team->users->contains(auth()->id()) && $team->owner_id !== auth()->id()) {
            abort(403, 'No tienes acceso a este equipo.');
        }

        // Obtener las listas de tareas para el equipo
        $taskLists = $team->taskLists()->with('tasks')->get();  // Trae las listas de tareas con sus tareas asociadas
        $members = $team->users;

        return view('board', compact('team', 'taskLists', 'members'));
    }

    public function storeTask(Request $request, Team $team)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'status' => 'required|in:' . implode(',', Task::statuses()),
        'task_list_id' => 'required|exists:task_lists,id',
    ]);

    // Verifica que la lista pertenece al equipo
    $taskList = TaskList::where('id', $request->task_list_id)
                        ->where('team_id', $team->id)
                        ->firstOrFail();

    $taskList->tasks()->create([
        'title' => $request->title,
        'description' => $request->description,
        'status' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Tarea creada correctamente.');
}


}
