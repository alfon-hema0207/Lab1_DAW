<?php
// Conexiones
require_once __DIR__ . '/config/db.php'; 
require_once __DIR__ . '/models/Usuario.php'; 

$usuarioModel = new Usuario();

// Procesar el formulario para crear o actualizar un usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    if ($id) {
        // Actualizar usuario existente
        $usuarioModel->actualizar($id, $nombre, $email);
    } else {
        // Crear nuevo usuario
        $usuarioModel->registrar($nombre, $email, $contraseña);
    }
}

// Procesar la eliminación de un usuario mediante su id
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $usuarioModel->eliminar($id);
}

// Obtener todos los usuarios para mostrar en la lista
$usuarios = $usuarioModel->obtenerTodos();

// Si existe el usuario del cual tenemos el id, lo podemos editar
$usuarioEditar = null;
if (isset($_GET['editar'])) {
    $idEditar = $_GET['editar'];
    foreach ($usuarios as $usuario) {
        if ($usuario['id'] == $idEditar) {
            $usuarioEditar = $usuario;
            break;
        }
    }
}
?>

<!-- Sección HTML del código para mostrar el formulario -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuarios</title>
</head>
<body>
    <h1>CRUD de Usuarios</h1>

    <!-- Formulario para crear/actualizar usuarios -->
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $usuarioEditar ? $usuarioEditar['id'] : '' ?>">
        <input type="text" name="nombre" placeholder="Nombre" value="<?= $usuarioEditar ? $usuarioEditar['nombre'] : '' ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?= $usuarioEditar ? $usuarioEditar['email'] : '' ?>" required>
        <input type="password" name="contraseña" placeholder="Contraseña" value="" <?= $usuarioEditar ? '' : 'required' ?>>
        <button type="submit">Guardar</button>
    </form>

    <!-- Listamos los usuarios en una tabla-->
    <h2>Lista de Usuarios</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Listamos todos los usuarios que tenemos registrados -->
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['id'] ?></td>
                    <td><?= $usuario['nombre'] ?></td>
                    <td><?= $usuario['email'] ?></td>
                    <td>
                        <!-- Para saber cuál usuario vamos a editar o eliminar, extraemos su id -->
                        <a href="?editar=<?= $usuario['id'] ?>">Editar</a>
                        <a href="?eliminar=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>