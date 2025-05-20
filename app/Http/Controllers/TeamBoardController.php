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
        $taskLists = $team->taskLists()->with('tasks')->get();
        $members = $team->users;

        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'review' => 'bg-purple-100 text-purple-800',
            'paused' => 'bg-gray-200 text-gray-700',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];
        $statusTexts = [
            'pending' => 'Pendiente',
            'in_progress' => 'En progreso',
            'review' => 'Revisión',
            'paused' => 'Pausado',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
        ];

        return view('taskboard', compact('team', 'taskLists', 'members', 'statusColors', 'statusTexts'));
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

    public function destroyTaskList($teamId, $taskListId)
    {
        // Eliminar la lista de tareas
        $taskList = TaskList::where('id', $taskListId)
            ->where('team_id', $teamId)
            ->firstOrFail();

        $taskList->delete();

        return response()->json(['success' => true]);
    }

    public function destroyTask($teamId, $taskId)
    {
        // Eliminar tarea
        $task = Task::where('id', $taskId)
            ->whereHas('taskList', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
            })->firstOrFail();

        $task->delete();

        return response()->json(['success' => true]);
    }


}
