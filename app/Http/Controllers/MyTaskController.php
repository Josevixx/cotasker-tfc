<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class MyTaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('assigned_to', Auth::id())
            ->with('taskList.team')
            ->latest()
            ->get();

        $statusTexts = [
            'pending' => 'Pendiente',
            'in_progress' => 'En progreso',
            'review' => 'Revisión',
            'paused' => 'Pausado',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
        ];

        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'review' => 'bg-purple-100 text-purple-800',
            'paused' => 'bg-orange-100 text-orange-800',
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];

        return view('mytasks', compact('tasks', 'statusColors', 'statusTexts'));
    }
}
?>