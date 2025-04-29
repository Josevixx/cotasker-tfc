<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Team;

class TaskListController extends Controller
{
    public function store(Request $request, Team $team)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $team->taskLists()->create([
        'name' => $request->name,
    ]);

    return redirect()->route('teams.board', $team->id)->with('success', 'Lista creada correctamente.');
}


}
