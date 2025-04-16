<?php
// Simulamos una "base de datos" con un arreglo de usuarios predefinidos
$usuarios = ["alejandro", "manolo", "alfonso"];

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Verificamos si el nombre de usuario ya existe
    if (in_array($username, $usuarios)) {
        echo json_encode(["exists" => true]);
    } else {
        echo json_encode(["exists" => false]);
    }
}
?>
