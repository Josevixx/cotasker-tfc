@extends('layouts.app')

@section('content')

<div class="min-h-screen">
    <!-- Contenido Principal -->
    <div class="flex flex-col items-center py-10">
        <!-- Encabezado -->
        <div class="w-3/5 bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-4xl font-bold ">{{ $team->name }}</h1>
            <p class="text-gray-600  mt-2">{{ $team->description }}</p>
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
                    <li class="py-3 text-gray-800 font-medium ">
                        {{ $member->name }} ({{ $member->email }})
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection
