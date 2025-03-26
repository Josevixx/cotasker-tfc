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

        // Agregar al usuario al equipo recién creado
        $team->users()->attach(auth()->id());

        // Redirigir al dashboard
        return redirect()->route('dashboard')->with('success', 'Equipo creado con éxito.');
    }

    public function join(Request $request)
    {
        // Validación del código de equipo
        $request->validate([
            'join_code' => 'required|string|exists:teams,join_code', // Asegurarse de que el código exista en la base de datos
        ]);

        // Buscar el equipo por su código
        $team = Team::where('join_code', $request->join_code)->first();

        if (!$team) {
            // Redirigir al dashboard con un mensaje de error si el código no es válido
            return redirect()->route('dashboard')->with('error', 'Código inválido.');
        }

        // Agregar al usuario al equipo
        $team->users()->attach(auth()->id());

        // Redirigir al dashboard con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Te has unido al equipo correctamente.');
    }

    public function show(Team $team)
    {
        // Verificar si el usuario pertenece al equipo
        if (!$team->users->contains(auth()->id()) && $team->owner_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'No tienes acceso a este equipo.');
        }

        $owner = $team->owner; // Obtener el dueño del equipo
        $members = $team->users->where('id', '!=', $team->owner_id); // Filtrar miembros sin incluir al dueño

        return view('team', compact('team', 'owner', 'members'));
    }

    public function kick(Team $team, User $user)
    {
        // Verificar si el usuario autenticado es el dueño del equipo
        if ($team->owner_id !== auth()->id()) {
            return redirect()->route('teams.show', $team->name)->with('error', 'No tienes permiso para expulsar miembros.');
        }

        // Eliminar la relación entre el equipo y el usuario
        $team->users()->detach($user->id);

        // Redirigir con un mensaje de éxito
        return redirect()->route('teams.show', $team->name)->with('success', 'Miembro expulsado correctamente.');
    }

    public function destroy($id)
{
    $team = Team::findOrFail($id);

    // Verificar que el usuario es el dueño del equipo
    if (auth()->user()->id === $team->owner_id) {
        $team->delete();
        return redirect()->route('dashboard')->with('success', 'Equipo eliminado correctamente.');
    }

    return redirect()->route('teams.show', $id)->with('error', 'No tienes permisos para eliminar este equipo.');
}

    public function index()
    {
        // Obtener los equipos del usuario autenticado, tanto los creados como los a los que se ha unido
        $teams = Team::where('owner_id', auth()->id()) // Equipos creados por el usuario
            ->orWhereHas('users', function ($query) { // Equipos a los que el usuario está unido
                $query->where('user_id', auth()->id());
            })
            ->get();

        // Pasar los equipos a la vista
        return view('dashboard', compact('teams'));
    }

}
