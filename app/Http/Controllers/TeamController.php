<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\User;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Crear el nuevo equipo
        $team = Team::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => auth()->id(),
        ]);

        // Agregar al usuario
        $team->users()->attach(auth()->id());

        return redirect()->route('dashboard');
    }

    public function join(Request $request)
    {
        $request->validate([
            'join_code' => 'required|string|exists:teams,join_code',
        ]);

        $team = Team::where('join_code', $request->join_code)->first();

        // Ya es miembro
        if ($team->users->contains(auth()->id())) {
            return redirect()->route('dashboard');
        }

        // Añadir al equipo
        $team->users()->attach(auth()->id());

        return redirect()->route('dashboard');
    }

    public function show(Team $team)
    {
        // Verificar si el usuario pertenece al equipo
        if (!$team->users->contains(auth()->id()) && $team->owner_id !== auth()->id()) {
            return redirect()->route('dashboard');
        }

        $owner = $team->owner;
        $members = $team->users->where('id', '!=', $team->owner_id);

        return view('team', compact('team', 'owner', 'members'));
    }

    public function kick(Team $team, User $user)
    {
        // Verificar si el usuario autenticado es el dueño del equipo
        if ($team->owner_id !== auth()->id()) {
            return redirect()->route('teams.show', $team->name);
        }

        // Eliminar la relación entre el equipo y el usuario
        $team->users()->detach($user->id);

        return redirect()->route('teams.show', $team->name);
    }
    
    public function leave(Team $team)
    {
        // Evitar que el dueño se autoexpulse
        if (auth()->id() === $team->owner_id) {
            return redirect()->route('dashboard');
        }

        $team->users()->detach(auth()->id());

        return redirect()->route('dashboard');
    }
    
    public function destroy($id)
    {
        $team = Team::findOrFail($id);

        // Verificar que el usuario es el dueño del equipo
        if (auth()->user()->id === $team->owner_id) {
            $team->delete();
            return redirect()->route('dashboard');
        }

        return redirect()->route('teams.show', $id);
    }

    public function index()
    {
        // Obtener los equipos 
        $teams = Team::where('owner_id', auth()->id())
            ->orWhereHas('users', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        return view('dashboard', compact('teams'));
    }

}
