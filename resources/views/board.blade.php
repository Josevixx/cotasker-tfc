@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">
    <!-- Encabezado -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-3xl font-bold">{{ $team->name }}</h1>
        <p class="text-gray-600">{{ $team->description }}</p>
    </div>

    <!-- Tareas -->
    <div class="bg-white shadow rounded-lg p-6 mt-4">
        <h2 class="text-2xl font-semibold mb-4">Tareas</h2>

        <!-- Verificar si hay listas de tareas -->
        @if($taskLists->isEmpty())
            <p class="text-gray-600">No hay listas de tareas para este equipo.</p>
        @else
            <!-- Mostrar las listas de tareas -->
            @foreach($taskLists as $taskList)
                <div class="task-list bg-gray-100 p-4 rounded-lg mb-4">
                    <h3 class="text-xl font-semibold">{{ $taskList->name }}</h3>

                    <!-- Verificar si hay tareas en esta lista -->
                    @if($taskList->tasks->isEmpty())
                        <p class="text-gray-600">No hay tareas en esta lista. ¡Agrega una nueva!</p>
                    @else
                        <ul class="task-list-items">
                            @foreach($taskList->tasks as $task)
                                <li class="task-item py-2">
                                    <p>{{ $task->title }} - {{ $task->status }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        @endif

        <!-- Botón para agregar tarea -->
        <div class="mt-6">
            <button onclick="openModal('createTaskModal')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Agregar tarea
            </button>
        </div>

    </div>
</div>

<!-- Modal para crear tarea -->
<div id="createTaskModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Crear nueva tarea</h2>
        <form action="{{ route('teams.tasks.store', $team) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="taskTitle" class="block text-gray-700">Título de la tarea</label>
                <input type="text" id="taskTitle" name="title" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="taskDescription" class="block text-gray-700">Descripción</label>
                <textarea id="taskDescription" name="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
            </div>

            <div class="mb-4">
                <label for="taskStatus" class="block text-gray-700">Estado</label>
                <select id="taskStatus" name="status" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="pending">Pendiente</option>
                    <option value="in_progress">En Progreso</option>
                    <option value="completed">Completada</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="taskList" class="block text-gray-700">Lista de tareas</label>
                <select id="taskList" name="task_list_id" class="w-full px-4 py-2 border rounded-lg" required>
                    @foreach($taskLists as $taskList)
                        <option value="{{ $taskList->id }}">{{ $taskList->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal('createTaskModal')"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Crear</button>
            </div>
        </form>
    </div>
</div>


@endsection
