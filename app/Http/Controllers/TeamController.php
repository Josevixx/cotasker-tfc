<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Crear el nuevo equipo en la base de datos
        $team = Team::create([
            'name' => $request->name,
            'description' => $request->description,
            'owner_id' => auth()->id(), // Asume que el usuario autenticado es el dueño
        ]);

        // Redirigir o retornar algún tipo de respuesta
        return redirect()->route('dashboard')->with('success', 'Equipo creado con éxito.');

    }

    public function index() {

        $teams = Team::where('owner_id', auth()->id())->get() ?? collect([]);

        return view('dashboard', compact('teams'));

    }
    

}
