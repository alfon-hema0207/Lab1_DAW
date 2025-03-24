<?php
// Conexiones
require_once __DIR__ . '/config/db.php'; 
require_once __DIR__ . '/models/Producto.php'; 

$productoModel = new Producto();

// Procesar el formulario para crear o actualizar un producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if ($id) {
        // Actualizar producto existente
        $productoModel->actualizar($id, $nombre, $descripcion, $precio, $stock);
    } else {
        // Crear nuevo producto
        $productoModel->crear($nombre, $descripcion, $precio, $stock);
    }
}

// Procesar la eliminación de un producto
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $productoModel->eliminar($id);
}

// Obtener todos los productos para mostrar en la lista
$productos = $productoModel->obtenerTodos();

// Mediante el id, obtenemos el producto que vamos a editar, solo en caso que exista
$productoEditar = null;
if (isset($_GET['editar'])) {
    $idEditar = $_GET['editar'];
    foreach ($productos as $producto) {
        if ($producto['id'] == $idEditar) {
            $productoEditar = $producto;
            break;
        }
    }
}
?>

<!-- Sección HTML, donde incluimos el formulario con las operaciones CRUD -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Productos</title>
</head>
<body>
    <h1>CRUD de Productos</h1>

    <!-- Formulario para crear/actualizar productos -->
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $productoEditar ? $productoEditar['id'] : '' ?>">
        <input type="text" name="nombre" placeholder="Nombre" value="<?= $productoEditar ? $productoEditar['nombre'] : '' ?>" required>
        <input type="text" name="descripcion" placeholder="Descripción" value="<?= $productoEditar ? $productoEditar['descripcion'] : '' ?>">
        <input type="number" name="precio" placeholder="Precio" value="<?= $productoEditar ? $productoEditar['precio'] : '' ?>" required>
        <input type="number" name="stock" placeholder="Stock" value="<?= $productoEditar ? $productoEditar['stock'] : '' ?>" required>
        <button type="submit">Guardar</button>
    </form>

    <!-- Listamos los productos con una tabla para mejor legibilidad-->
    <h2>Lista de Productos</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Listamos todos los productos que tenemos en existencia -->
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $producto['id'] ?></td>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['descripcion'] ?></td>
                    <td><?= $producto['precio'] ?></td>
                    <td><?= $producto['stock'] ?></td>
                    <td>
                        <!-- Para editar y eliminar, tomamos el id -->
                        <a href="?editar=<?= $producto['id'] ?>">Editar</a>
                        <a href="?eliminar=<?= $producto['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>