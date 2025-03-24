<?php
require_once __DIR__ . '/../config/db.php';

class Producto {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function crear($nombre, $descripcion, $precio, $stock) {
        $stmt = $this->conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $descripcion, $precio, $stock]);
    }

    public function obtenerTodos() {
        $stmt = $this->conn->query("SELECT * FROM productos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $stock) {
        $stmt = $this->conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?");
        $stmt->execute([$nombre, $descripcion, $precio, $stock, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un arreglo asociativo del producto
    }    
    

    public function buscar($nombre = null, $precio_min = null, $precio_max = null) {
        $sql = "SELECT * FROM productos WHERE 1=1";
        $params = [];
    
        if ($nombre) {
            $sql .= " AND nombre LIKE :nombre";
            $params[':nombre'] = "%$nombre%";
        }
        if ($precio_min) {
            $sql .= " AND precio >= :precio_min";
            $params[':precio_min'] = $precio_min;
        }
        if ($precio_max) {
            $sql .= " AND precio <= :precio_max";
            $params[':precio_max'] = $precio_max;
        }
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
