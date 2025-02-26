<?php

include 'conexion.php';

$nombre = "Valerie MazaMar";
$correo = "vale_mazamar@gmail.com";

$sql = "INSERT INTO usuarios (nombre, correo) VALUES ('$nombre', '$correo')";

if ($conexion->query($sql) === TRUE) {
	echo "El usuario ha sido registrado en la base de datos";
} else {
	echo "Error: " . $conexion->error;
}

$conexion->close();

?>