<?php

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formularios_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Fallo al conectar: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = trim($_POST["nombre"]);
$email = trim($_POST["email"]);
$edad = trim($_POST["edad"]);

// Verificar que los campos no estén vacíos con la funcion empty
if (empty($nombre) || empty($email) || empty($edad)) { # Revisa todos los campos 
    die("Error: Todos los campos deben ser completados.");
}

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: Formato de correo incorrecto.");
}

// Validar edad 
if (!filter_var($edad, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
    die("Error: La edad debe ser un número entero positivo.");
}

// Evita el registro en caso de que no cumpla los criterios
$nombre = $conn->real_escape_string($nombre);
$email = $conn->real_escape_string($email);
$edad = (int)$edad; // Convierte la edad a entero

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (nombre, correo, edad) VALUES ('$nombre', '$email', $edad)";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso. <a href='mostrar_datos.php'>Ver usuarios</a>";
} else {
    echo "Error al registrar: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

?>
