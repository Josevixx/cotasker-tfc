@extends('layouts.app')

@section('content')

    <div class="container mx-auto p-6 space-y-6">
        <!-- Titulo, Descripción y Gestionar -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ $team->name }}</h1>
                    <p class="text-gray-600">{{ $team->description }}</p>
                </div>
                <!-- Ruta para gestionar el equipo -->
                <a href="{{ route('teams.show', $team) }}"
                    class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition mr-4">
                    Gestionar equipo
                </a>
            </div>
        </div>

        <!-- Botón para crear una nueva lista de tareas -->
        @if ($taskLists->isEmpty())
            <div class="mt-4 text-center">
                <div class="bg-white shadow rounded-lg p-6 text-center">
                    <button onclick="openModal('createListModal')"
                        class="bg-purple-600 text-white px-4 py-2 mb-4 rounded-lg hover:bg-purple-700">
                        Crear lista de tareas
                    </button>
                    <p class="text-gray-600 mb-4">No hay listas de tareas aún. Crea una para empezar a organizar tu equipo.</p>
                </div>
            </div>
        @else
            <div class="mt-4">

                <div class="flex space-x-2 mb-4">
                    <button onclick="openModal('createListModal')"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                        Nueva lista
                    </button>

                    <button onclick="openModal('createTaskModal')"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Agregar tarea
                    </button>
                </div>
                <!-- Listas de tareas -->
                <div class="flex space-x-4 overflow-auto pb-4">
                    @foreach($taskLists as $taskList)
                        <div class="w-80 flex-shrink-0 bg-white rounded-lg shadow p-4">
                            <h3 class="text-xl font-semibold mb-4">{{ $taskList->name }}</h3>

                            <div id="task-list-{{ $taskList->id }}" class="task-list space-y-3 min-h-[100px]">
                                @foreach($taskList->tasks as $task)
                                    <div class="task bg-gray-100 p-3 rounded shadow hover:shadow-md transition-transform transform hover:scale-[1.02] cursor-move"
                                        data-id="{{ $task->id }}">
                                        <p class="text-sm font-medium">{{ $task->title }}</p>
                                        <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <!-- Modal para crear lista -->
    <div id="createListModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-auto">
            <h2 class="text-2xl font-semibold mb-4">Crear nueva lista de tareas</h2>
            <form action="{{ route('task-lists.store', $team) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="listName" class="block text-gray-700">Nombre de la lista</label>
                    <input type="text" id="listName" maxlength="30" name="name" class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('createListModal')"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Crear
                        lista</button>
                </div>
            </form>
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
                    <input type="text" id="taskTitle" name="title" maxlength="30" class="w-full px-4 py-2 border rounded-lg" required>
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
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Crear</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const lists = document.querySelectorAll('.task-list');

            lists.forEach((list) => {
                new Sortable(list, {
                    group: 'shared-tasks',
                    animation: 150,
                    ghostClass: 'bg-blue-100',
                    onEnd: function (evt) {
                        const taskId = evt.item.dataset.id;
                        const newListId = evt.to.id.replace('task-list-', '');

                        fetch(`/tasks/${taskId}/move`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                task_list_id: newListId,
                                new_index: evt.newIndex
                            })
                        });
                    }
                });
            });
        });
    </script>

@endsection