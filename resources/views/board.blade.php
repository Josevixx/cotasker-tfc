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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 items-start">
                    @foreach($taskLists as $taskList)
                            <div class="bg-white rounded-lg shadow p-4 flex flex-col">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold">{{ $taskList->name }}</h3>  
                                    <button class="text-gray-500 hover:text-red-500" title="Eliminar lista">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m3-3h4a1 1 0 011 1v1H8V5a1 1 0 011-1z" />
                                          </svg>                                          
                                    </button>
                                </div>

                                <?php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'in_progress' => 'bg-blue-100 text-blue-800',
                            'review' => 'bg-purple-100 text-purple-800',
                            'paused' => 'bg-gray-200 text-gray-700',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                                                                ?>

                                <div id="task-list-{{ $taskList->id }}" class="task-list space-y-3 min-h-[100px]">
                                    @foreach($taskList->tasks as $task)
                                        <div class="task bg-gray-100 p-3 rounded shadow hover:shadow-md transition-transform transform hover:scale-[1.02] cursor-move relative"
                                            data-id="{{ $task->id }}">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-sm font-medium">{{ $task->title }}</p>
                                                    <span
                                                        class="inline-block text-xs px-2 py-1 rounded {{ $statusColors[$task->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                    </span>
                                                </div>
                                                <button class="text-gray-400 hover:text-red-500 ml-2 mt-1" title="Eliminar tarea">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m3-3h4a1 1 0 011 1v1H8V5a1 1 0 011-1z" />
                                                    </svg>
                                                </button>
                                            </div>
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
                    <input type="text" id="listName" maxlength="20" name="name" class="w-full px-4 py-2 border rounded-lg"
                        required>
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
                    <input type="text" id="taskTitle" name="title" maxlength="30" class="w-full px-4 py-2 border rounded-lg"
                        required>
                </div>
                <div class="mb-4">
                    <label for="taskDescription" class="block text-gray-700">Descripción</label>
                    <textarea id="taskDescription" name="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
                <div class="mb-4">
                    <label for="taskStatus" class="block text-gray-700">Estado</label>
                    <select id="taskStatus" name="status" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="review">Review</option>
                        <option value="paused">Paused</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
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