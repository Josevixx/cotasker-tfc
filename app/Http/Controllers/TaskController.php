<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
public function move(Request $request, Task $task)
{
    $validated = $request->validate([
        'task_list_id' => 'required|exists:task_lists,id',
        'new_index' => 'nullable|integer',
    ]);

    $task->task_list_id = $validated['task_list_id'];
    $task->save();

    // Actualiza la tarea a la lista de tareas correspondiente
    return response()->json(['success' => true]);
}


}
