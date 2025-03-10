<?php

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formularios_db";

# Guardamos la conexion en una variable
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die ("Fallo al conectar: " . $conn->connect_error);
}

// Verificar si se ha recibido un ID, esto es necesario para saber si haremos la edición.
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("ID de usuario no proporcionado.");
}

$id = $_GET["id"];

// Obtener los datos del usuario de la base de datos.
$sql = "SELECT nombre, correo, edad FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

# Notificar al usuario en caso de que no se encuentre el registro en la base
if ($result->num_rows === 0) {
    die("Usuario no encontrado.");
}

$usuario = $result->fetch_assoc();

// Si el formulario es enviado, actualizamos los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["email"];
    $edad = $_POST["edad"];

    // Actualizar los datos en la base de datos
    $sql_update = "UPDATE usuarios SET nombre = ?, correo = ?, edad = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssii", $nombre, $correo, $edad, $id); // SSII = string, string, int, int
    
    if ($stmt_update->execute()) {
        echo "Usuario actualizado correctamente. <a href='mostrar_datos.php'>Volver</a>";
    } else {
        echo "Error al actualizar el usuario.";
    }

    $stmt_update->close();
    exit();
}

$stmt->close();
$conn->close();

?>

<!-- Esta será la sección de html del código, la cual es la interfaz para editar los datos de los usuarios -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Editar Usuario</h1>     
<!--Nuevamente es un formulario, ya que es donde modificaremos los usuarios
    Usamos la parte de "htmlspecialchars" para asegurarnos que al momento de la edición,
    no se introduzcan entradas con caracteres especiales y que nos puedan afectar  -->
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required><br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" value="<?php echo htmlspecialchars($usuario['edad']); ?>" required><br><br>

        <button type="submit">Actualizar</button>
    </form>
    <br>
    <a href="mostrar_datos.php">Cancelar</a>
</body>
</html>
