@extends('layouts.app')

@section('content')

    <div class="min-h-screen">
        <!-- Contenido Principal -->
        <div class="flex flex-col items-center py-10">
            <!-- Encabezado -->
            <div class="w-3/5 bg-white shadow-lg rounded-lg p-8">
                <h1 class="text-4xl font-bold ">{{ $team->name }}</h1>
                <p class="text-gray-600  mt-2">{{ $team->description }}</p>

                @if(auth()->user()->id === $team->owner_id)
                    <div class="mt-4">
                        <p class="font-semibold text-lg">Código de invitación: <span
                                class="text-blue-500">{{ $team->join_code }}</span></p>
                    </div>
                @endif
            </div>

            <!-- Lista de Miembros -->
            <div class="w-3/5 bg-white shadow-lg rounded-lg p-8 mt-6">
                <h2 class="text-2xl font-semibold  mb-4">Miembros del equipo</h2>

                <!-- Dueño del equipo -->
                <div class="bg-gray-100 p-4 rounded-lg mb-4 ">
                    <p class="text-lg font-bold">{{ $owner->name }} (Admin)</p>
                    <p class="text-gray-600 text-sm">{{ $owner->email }}</p>
                </div>

                <!-- Otros miembros -->
                <ul class="divide-y divide-gray-300">
                    @foreach($members as $member)
                        <li class="flex justify-between items-center py-3 text-gray-800 font-medium ">
                            {{ $member->name }} ({{ $member->email }})
                            
                            <!-- Línea entre el nombre y gmail y el boton -->
                            <div class="flex-grow border-t border-gray-300 mx-4"></div>

                            <!-- Botón de Expulsar -->
                            @if($owner->id === auth()->id())
                                <form method="POST" action="{{ route('teams.kick', ['team' => $team->id, 'user' => $member->id]) }}"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('¿Estás seguro de que quieres expulsar a este usuario?')" type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-semibold">
                                        Expulsar
                                    </button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>

            </div>
            <!-- Eleminar Equipo -->
            @if(auth()->user()->id === $team->owner_id)
                <div class="mt-6 flex justify-end">
                    <form id="delete-team-form" action="{{ route('teams.destroy', $team->id) }}" method="POST"
                        style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button onclick="confirmDeleteTeam()" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                        Eliminar equipo
                    </button>
                </div>
            @endif

            <!-- Confirmación de abandonar -->
            @if(auth()->id() !== $team->owner_id)
                <form action="{{ route('teams.leave', $team->id) }}" method="POST" class="mt-6">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('¿Estás seguro de que quieres abandonar este equipo?')"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">
                        Abandonar equipo
                    </button>
                </form>
            @endif


            <script>
                //Confirmación de eliminar equipo
                function confirmDeleteTeam() {
                    if (confirm('¿Estás seguro de que quieres eliminar este equipo? Esta acción no se puede deshacer.')) {
                        document.getElementById('delete-team-form').submit();
                    }
                }
            </script>


        </div>
    </div>

@endsection