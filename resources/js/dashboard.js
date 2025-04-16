
//Limite de caracteres en la descripción
document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('description');
    const counter = document.getElementById('charCount');

    textarea.addEventListener('input', () => {
        const remaining = 30 - textarea.value.length;
        counter.textContent = `${remaining} caracteres restantes`;
    });
});

//Limpia los campos del modal al cerrarlo
// y restablece el contador de caracteres al pulsar "Cancelar"
document.addEventListener('DOMContentLoaded', () => {
    const cancelBtn = document.getElementById('cancelBtn');
    const modal = document.getElementById('createTeamModal');

    cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        const inputs = modal.querySelectorAll('input, textarea');
        inputs.forEach(input => input.value = '');
        const textarea = document.getElementById('description');
        const counter = document.getElementById('charCount');
        counter.textContent = `${30 - textarea.value.length} caracteres restantes`;
    });
});

//Cerrar modal si se hace clic fuera
window.onclick = function (event) {
    const modal = document.getElementById('createTeamModal');
    if (event.target == modal) {
        document.getElementById('createTeamModal').style.display = "none";
    }
}