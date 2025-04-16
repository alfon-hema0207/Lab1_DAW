const entradaTarea = document.getElementById("tarea");
const botonTarea = document.getElementById("agregarTarea");
const listaTareas = document.getElementById("listaTareas");

// Funcion para agregar un elemento a la lista de tareas
function agregarElemento() {
    const textoTarea = entradaTarea.value;

    if (textoTarea.trim() !== "") {
        const nuevaTarea = document.createElement("li");

        // Crear el span con el texto
        const spanTexto = document.createElement("span");
        spanTexto.textContent = textoTarea;
        spanTexto.addEventListener("click", function () {
            spanTexto.classList.toggle("completada");
        });

        // Crear botón eliminar
        const botonEliminar = document.createElement("button");
        botonEliminar.textContent = "Eliminar tarea";
        botonEliminar.classList.add("eliminar-btn");
        botonEliminar.addEventListener("click", function () {
            listaTareas.removeChild(nuevaTarea);
        });

        nuevaTarea.appendChild(spanTexto);
        nuevaTarea.appendChild(botonEliminar);
        listaTareas.appendChild(nuevaTarea);
        entradaTarea.value = ""; // Reiniciamos el campo una vez que se agregó la tarea.
    }
}

botonTarea.addEventListener("click", agregarElemento);
