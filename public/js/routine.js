document.addEventListener('DOMContentLoaded', function() {
    const routineButtons = document.querySelectorAll('.routine-button');
    const dayButtons = document.querySelectorAll('.day-button');
    const dayContents = document.querySelectorAll('.day-content');

    // Función para cambiar de rutina
    function changeRoutine(routineKey) {
        // Redirigir a la misma página con el parámetro de rutina
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('routine', routineKey);
        window.location.href = currentUrl.toString();
    }

    // Función para mostrar un día específico
    function showDay(dayKey) {
        // Ocultar todos los días
        dayContents.forEach(content => {
            content.style.display = 'none';
        });

        // Remover clase activa de todos los botones de día
        dayButtons.forEach(button => {
            button.classList.remove('active');
        });

        // Mostrar el día seleccionado
        const selectedDay = document.getElementById('day-' + dayKey);
        if (selectedDay) {
            selectedDay.style.display = 'block';
        }

        // Agregar clase activa al botón seleccionado
        const selectedButton = document.querySelector(`[data-day="${dayKey}"]`);
        if (selectedButton) {
            selectedButton.classList.add('active');
        }
    }

    // Event listeners para botones de rutina
    routineButtons.forEach(button => {
        button.addEventListener('click', function() {
            const routineKey = this.getAttribute('data-routine');
            changeRoutine(routineKey);
        });
    });

    // Event listeners para botones de día
    dayButtons.forEach(button => {
        button.addEventListener('click', function() {
            const dayKey = this.getAttribute('data-day');
            showDay(dayKey);
        });
    });

    // Activar el primer día por defecto
    if (dayButtons.length > 0) {
        dayButtons[0].classList.add('active');
    }
});