<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Team;

class TaskController extends Controller
{
    public function move(Request $request, Task $task)
    {
        $task->task_list_id = $request->task_list_id;
        $task->order = $request->new_index;
        $task->save();

        return response()->json(['success' => true]);
    }

}
