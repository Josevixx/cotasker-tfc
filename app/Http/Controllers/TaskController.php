<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function move(Request $request, Task $task)
    {
        // Mueve la tarea a una nueva lista de tareas
        $validated = $request->validate([
            'task_list_id' => 'required|exists:task_lists,id',
            'new_index' => 'nullable|integer',
        ]);

        $task->task_list_id = $validated['task_list_id'];
        $task->save();

        return response()->json(['success' => true]);
    }
    public function edit(Task $task)
    {
        $teamUsers = $task->taskList->team->users; // Obtener los usuarios del equipo al que pertenece la tare
        return response()->json([
            'task' => $task,
            'users' => $teamUsers
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,review,paused,completed,cancelled',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);

        return response()->json(['message' => 'Tarea actualizada correctamente']);
    }

    public function myTasks()
    {
        $tasks = Task::where('assigned_to', Auth::id())
            ->with(['taskList'])
            ->latest()
            ->get();

        return view('tasks.mine', compact('tasks'));
    }


}
