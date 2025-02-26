<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "usuarios_db";

// Crear conexion
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

//Verificar conexion
if ($conexion->connect_error) {
	die("Error en la conexion: " . $conexion->connect_error);
} else {
	echo "Conexion establecida con exito". "<br>";
}
?>