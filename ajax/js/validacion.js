document.getElementById("username").addEventListener("input", function() {
    const username = this.value;

    // Evita hacer la solicitud si el campo está vacío
    if (username.trim() === "") {
        document.getElementById("response").innerHTML = "";
        return;
    }

    // Llamada AJAX simulada
    fetch('validacion.php?username=' + username)
        .then(response => response.json())  // Asegúrate de que la respuesta sea en formato JSON
        .then(data => {
            const responseElement = document.getElementById("response");

            // Limpiar cualquier clase previa (error o success)
            responseElement.classList.remove("error", "success");

            // Mostrar el mensaje dependiendo de la respuesta del servidor
            if (data.exists) {
                responseElement.innerHTML = "El nombre de usuario ya está en uso.";
                responseElement.classList.add("error");  // Clase para error
            } else {
                responseElement.innerHTML = "Nombre de usuario disponible.";
                responseElement.classList.add("success");  // Clase para éxito
            }
        })
        .catch(error => {
            console.error('Error al validar el nombre de usuario:', error);
        });
});
