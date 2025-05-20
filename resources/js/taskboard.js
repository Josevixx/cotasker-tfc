import { deleteItem } from './deleteTasks';
import Sortable from 'sortablejs';

document.addEventListener('DOMContentLoaded', () => {
    // Eliminar lista
    const deleteListButtons = document.querySelectorAll('.delete-list');
    deleteListButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const listId = button.getAttribute('data-id');
            if (confirm('¿Estás seguro de que quieres eliminar esta lista y todas sus tareas?')) {
                deleteItem('list', listId);
            }
        });
    });

    // Eliminar tarea
    const deleteTaskButtons = document.querySelectorAll('.delete-task');
    deleteTaskButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const taskId = button.getAttribute('data-id');
            if (confirm('¿Estás seguro de que quieres eliminar esta tarea?')) {
                deleteItem('task', taskId);
            }
        });
    });
});


//Filtro de tareas
document.addEventListener('DOMContentLoaded', () => {
    const filter = document.getElementById('statusFilter');

    filter.addEventListener('change', () => {
        const selectedStatus = filter.value;

        // Mostrar/ocultar tareas según el estado
        document.querySelectorAll('.task').forEach(task => {
            const taskStatus = task.getAttribute('data-status');
            const shouldShow = !selectedStatus || taskStatus === selectedStatus;
            task.classList.toggle('hidden', !shouldShow);
        });

        // Mostrar/ocultar listas según si tienen tareas visibles
        document.querySelectorAll('.task-list-wrapper').forEach(list => {
            const visibleTasks = list.querySelectorAll('.task:not(.hidden)');
            if (!selectedStatus) {
                list.classList.remove('hidden');
            } else {
                list.classList.toggle('hidden', visibleTasks.length === 0);
            }
        });
    });
});

//Buscador de tareas
document.addEventListener('DOMContentLoaded', () => {
    const filter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('taskSearch');

    const filterTasks = () => {
        const selectedStatus = filter.value;
        const searchQuery = searchInput.value.toLowerCase();

        // Filtrar tareas por estado
        document.querySelectorAll('.task').forEach(task => {
            const taskStatus = task.getAttribute('data-status');
            const taskTitle = task.querySelector('p').textContent.toLowerCase();

            // Verificar si la tarea debe mostrarse
            const matchesStatus = !selectedStatus || taskStatus === selectedStatus;
            const matchesSearch = taskTitle.includes(searchQuery);

            const shouldShow = matchesStatus && matchesSearch;

            task.classList.toggle('hidden', !shouldShow);
        });

        // Mostrar/ocultar listas según si tienen tareas visibles
        document.querySelectorAll('.task-list-wrapper').forEach(list => {
            const visibleTasks = list.querySelectorAll('.task:not(.hidden)');
            if (!selectedStatus && !searchQuery) {
                list.classList.remove('hidden');
            } else {
                list.classList.toggle('hidden', visibleTasks.length === 0);
            }
        });
    };

    // Escuchar cambios en el filtro de estado
    filter.addEventListener('change', filterTasks);

    // Escuchar cambios en el campo de búsqueda
    searchInput.addEventListener('input', filterTasks);
});


// Habilitar Sortable en las listas de tareas
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                    ,
                    body: JSON.stringify({
                        task_list_id: newListId,
                        new_index: evt.newIndex
                    })
                });
            }
        });
    });
});

const board = document.getElementById('board');

if (board) {
    Sortable.create(board, {
        animation: 200,
        ghostClass: 'bg-gray-200',
        handle: '.drag-handle',
    });
}

// Modal de creación de tareas
document.querySelectorAll('.task').forEach(taskEl => {
    taskEl.addEventListener('click', (e) => {
        if (e.target.closest('.delete-task')) return;

        const taskId = taskEl.dataset.id;

        fetch(`/tasks/${taskId}/edit`)
            .then(response => response.json())
            .then(data => {
                const task = data.task;
                const users = data.users;

                document.getElementById('editTaskId').value = task.id;
                document.getElementById('editTitle').value = task.title;
                document.getElementById('editDescription').value = task.description || '';
                document.getElementById('editStatus').value = task.status;
                document.getElementById('editDueDate').value = task.due_date || '';

                const assignedSelect = document.getElementById('editAssignedTo');
                assignedSelect.innerHTML = '<option value="">Sin asignar</option>';
                users.forEach(user => {
                    assignedSelect.innerHTML += `<option value="${user.id}" ${user.id == task.assigned_to ? 'selected' : ''}>${user.name}</option>`;
                });

                openModal('editTaskModal');
            });
    });
});

document.getElementById('editTaskForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const taskId = document.getElementById('editTaskId').value;
    const formData = new FormData(form);

    fetch(`/tasks/${taskId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
        .then(res => {
            if (!res.ok) throw new Error('Error al actualizar');
            return res.json();
        })
        .then(data => {
            location.reload(); // Refrescar para ver cambios actualizados
        })
        .catch(err => {
            alert('Error al actualizar la tarea');
            console.error(err);
        });
});
