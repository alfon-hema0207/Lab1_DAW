<?php

header("Content-Type:aplication/json");
header("Acces-Control-Allow-Origin:*");
header("Acces-Control-Allow-Methods:GET,POST,PUT,DELETE");
header("Acces-Control-Allow-Headers:Content-Type");

$conn = new mysqli("localhost","root","","productos");

if($conn->connect_error){
    die ("Conexión fallida:".$conn->connect_error);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method){
    case 'GET':
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);
        $products = [];
        while ($row = $result->fetch_assoc()){
            $products[] = $row;
        }
        echo json_encode($products);
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents("php://input"),true);
        $nombre = $data['nombre'];
        $descripcion = $data['descripcion'];
        $precio = $data['precio'];
        $sql = "INSERT INTO productos (nombre, descripcion, precio) VALUES ('$nombre','$descripcion','$precio')";
        if($conn->query($sql)===TRUE){
            echo json_encode(["message"=>"Producto creado"]);
        } else {
            echo json_encode(["Error"=>$con->error]);
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'];
        $nombre = $data['nombre'];
        $descripcion = $data['descripcion'];
        $precio = $data['precio'];
        $sql = "UPDATE productos SET nombre='$nombre', descripcion = '$descripcion', precio = $precio WHERE id = $id";
        if($conn->query($sql)===TRUE){
            echo json_encode(["message" => "Producto actualizado"]);
        } else {
            echo json_encode(["Error" => $conn->error]);
        }
        break;
        
    case 'DELETE':
        $id = $_GET['id'];
        $sql = "DELETE FROM productos WHERE id = $id";
        if($conn->query($sql)===TRUE){
            echo json_encode(["message"=>"Producto eliminado"]);
        } else {
            echo json_encode(["error"=>$conn_error]);
        }
        break;
}

$conn->close();
?>
