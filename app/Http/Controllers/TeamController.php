<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

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
