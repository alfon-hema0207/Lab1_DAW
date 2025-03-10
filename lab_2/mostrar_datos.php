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

// En una variables asignamos cuantos registros se van a mostrar en cada página
$registros_por_pagina = 5;

// Obtener el número de página actual
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// Este es el registro en el cual comenzará a mostrarse en la página
$inicio = ($pagina_actual - 1) * $registros_por_pagina;

// Contar el número total de registros
$sql_total = "SELECT COUNT(*) AS total FROM usuarios";
$result_total = $conn->query($sql_total);
$total_registros = $result_total->fetch_assoc()['total'];

// Hacemos la cuenta para ver el total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Consultar los datos con el límite y el desplazamiento
$sql = "SELECT id, nombre, correo, edad FROM usuarios LIMIT $inicio, $registros_por_pagina";
$result = $conn->query($sql);

// La parte del HTML, esta es la sección que mostrará los registros en la pantalla
if ($result->num_rows > 0) {
    echo "<link rel='stylesheet' href='estilos.css'>";
    echo "<h1>Usuarios Registrados</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Edad</th><th>Editar</th><th>Eliminar</th></tr>"; // Filas y columnas
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>"; # Campos que se muestran en la tabla 
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["correo"] . "</td>";
        echo "<td>" . $row["edad"] . "</td>";
        echo "<td><a href='editar_usuario.php?id=" . $row["id"] . "'>Editar</a></td>"; // Enlace para el código de edición
        echo "<td><a href='eliminar_usuario.php?id=" . $row["id"] . "' onclick='return confirm(\"¿Desea eliminar el usuario seleccionado? Ya no habrá vuelta atrás\");'>Eliminar</a></td>"; // Enlace al código de eliminación
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aún no hay usuarios registrados"; // Si no hay registros, se lo notifica al usuario
}

// Mostrar enlaces de paginación, para hacer la "navegación"
echo "<div class='paginacion'>";
if ($pagina_actual > 1) {
    echo "<a href='?pagina=" . ($pagina_actual - 1) . "'>Anterior</a> ";
}
for ($i = 1; $i <= $total_paginas; $i++) {
    echo "<a href='?pagina=$i' " . ($i == $pagina_actual ? "style='font-weight: bold;'" : "") . ">$i</a> ";
}
if ($pagina_actual < $total_paginas) {
    echo "<a href='?pagina=" . ($pagina_actual + 1) . "'>Siguiente</a>";
}
echo "</div>";

// Haciendo las pruebas, me di cuenta de la necesidad de un enlace que me lleve de regreso al formulario de registros.
echo "<a href='formulario.html'>Volver al formulario de registro</a>";

// Cerrar la conexión
$conn->close();

?>
