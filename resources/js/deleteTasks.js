export function deleteItem(type, id) {
    const teamId = document.getElementById('board').dataset.teamId;

    let url = '';
    if (type === 'task') {
        url = `/teams/${teamId}/tasks/${id}`;
    } else if (type === 'list') {
        url = `/teams/${teamId}/task-lists/${id}`;
    }

    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(async res => {
        if (!res.ok) throw new Error('Respuesta no válida del servidor');
        const data = await res.json();

        if (data.success) {
            const element = document.querySelector(`[data-id="${id}"]`);
            if (element) {
                if (type === 'task') {
                    element.closest('.task').remove();
                } else if (type === 'list') {
                    element.closest('.task-list-wrapper').remove();
                }
            }
        } else {
            alert('No se pudo eliminar. Intenta de nuevo.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error de red al intentar eliminar.');
    });
}
