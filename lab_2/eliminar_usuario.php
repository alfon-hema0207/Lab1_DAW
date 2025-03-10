<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formularios_db";

$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar la conexión
if ($conn->connect_error) {
    die ("Fallo al conectar: " . $conn->connect_error);
}

// Verificar si se ha recibido un ID, que es el que eliminaremos 
if (!isset($_GET["id"]) || empty($_GET["id"])) {
    die("ID de usuario no proporcionado."); // Si no recibimos un ID, lo notificamos al usuario.
}

$id = $_GET["id"];

// Eliminar el usuario de la base de datos
$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
echo "<link rel='stylesheet' href='estilos.css'>";
if ($stmt->execute()) {
    // Una vez eliminado, se lo notificamos al usuario.
    echo "Usuario eliminado correctamente. <a href='mostrar_datos.php'>Volver</a>";
} else {
    echo "Error al eliminar el usuario."; // Si no se pudo eliminar, igualmente se le notifica al usuario.
}
$stmt->close();
$conn->close();

?>
