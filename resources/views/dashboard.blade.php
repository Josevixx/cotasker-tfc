@extends('layouts.app')

@section('content')
@vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])
    <br>
    <!-- Header -->
    <header class="bg-white py-10 shadow-md rounded-3xl mx-20">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex-1 text-center">
                <h1 class="text-3xl font-bold">Bienvenido a CoTasker</h1>
                <p class="text-gray-600 mt-2">Organiza tus equipos de trabajo y gestiona tus tareas de manera eficiente.
                </p>
                <div class="mt-4">
                    <button onclick="document.getElementById('createTeamModal').style.display='block'"
                        class="btn btn-primary">
                        Crear un Equipo
                    </button>
                </div>
            </div>

            <!-- Formulario para unirse a un equipo -->
            <div class="w-1/4 bg-white p-6 ml-6 ring-4 rounded-lg">
                <h2 class="text-xl font-bold mb-4">Unirse a un Equipo</h2>
                <form action="{{ route('teams.join') }}" method="POST">
                    @csrf
                    <input type="text" placeholder="Código de equipo" name="join_code" required
                        class="w-full px-4 py-2 border rounded-lg mt-2">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-700 transition duration-300">
                        Unirse
                    </button>
                </form>
            </div>
        </div>
    </header>


    <!-- Cajas de los equipos -->
    <section class="container mx-auto my-10 mb-20 content">
        <h2 class="text-2xl font-bold mb-4">Tus Equipos</h2>
        @if ($teams->isNotEmpty())
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($teams as $team)
                    <a href="{{ route('teams.board', $team->id) }}" class="block">
                        <div
                            class="p-5 bg-white shadow-md rounded-lg flex justify-between items-center hover:shadow-lg hover:scale-[1.01] transition duration-200">
                            <div>
                                <h3 class="text-xl font-bold text-blue-600">{{ $team->name }}</h3>
                                <p class="text-gray-600">{{ $team->description }}</p>
                            </div>
                            <div class="flex items-center space-x-2 bg-gray-100 px-3 py-1 rounded-full">
                                <span class="text-lg font-semibold text-gray-700 select-none">{{ $team->users->count() }}</span>
                                <span class="text-xl select-none">👥</span>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        @else
            <p class="text-gray-600">No tienes equipos creados aún.</p>
        @endif


    </section>

    <!-- Modal para crear equipo -->
    <div id="createTeamModal" class="fixed inset-0 justify-items-center z-50 bg-gray-900 bg-opacity-50"
        style="display:none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-20 mt-[140px]">
            <h2 class="text-xl font-semibold mb-4">Crear Nuevo Equipo</h2>

            <form action="{{ route('teams.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Nombre del equipo</label>
                    <input type="text" name="name" maxlength="25" required class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Descripción (opcional)</label>
                    <textarea name="description" id="description" maxlength="30" class="w-full px-4 py-2 border rounded-lg"
                        placeholder="Máx. 30 caracteres"></textarea>
                    <p id="charCount" class="text-sm text-gray-500 mt-1">30 caracteres restantes</p>
                    <!-- Función contador de carácteres -->
                </div>


                <div class="flex justify-end space-x-2">
                    <button id="cancelBtn" type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection