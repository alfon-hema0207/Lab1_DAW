<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $productoModel;

    public function __construct() {
        $this->productoModel = new Producto();
    }

    public function crear() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['nombre']) || empty($data['precio']) || empty($data['stock'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre, precio y stock son obligatorios']);
            return;
        }

        $this->productoModel->crear(
            $data['nombre'],
            $data['descripcion'] ?? '',
            $data['precio'],
            $data['stock']
        );
        echo json_encode(['mensaje' => 'Producto creado']);
    }

    public function obtenerTodos() {
        $productos = $this->productoModel->obtenerTodos();
        echo json_encode($productos);
    }

    public function actualizar($id) {
        // Obtener los datos enviados
        $data = json_decode(file_get_contents('php://input'), true);
    
        // Verificar si el producto existe
        $productoExistente = $this->productoModel->obtenerPorId($id);
        if (!$productoExistente) {
            http_response_code(404);
            echo json_encode(['error' => 'Producto no encontrado']);
            return;
        }
    
        // Verificar que los campos necesarios estén presentes
        if (empty($data['nombre']) || empty($data['precio']) || empty($data['stock'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre, precio y stock son obligatorios']);
            return;
        }
    
        // Actualizar el producto
        $this->productoModel->actualizar(
            $id,
            $data['nombre'],
            $data['descripcion'] ?? '',
            $data['precio'],
            $data['stock']
        );
    
        echo json_encode(['mensaje' => 'Producto actualizado']);
    }    
    

    public function eliminar($id) {
        $this->productoModel->eliminar($id);
        echo json_encode(['mensaje' => 'Producto eliminado']);
    }
    
    public function buscar() {
        $params = $_GET; // Obtener parámetros de la URL
    
        $nombre = $params['nombre'] ?? null;
        $precio_min = $params['precio_min'] ?? null;
        $precio_max = $params['precio_max'] ?? null;
    
        $productos = $this->productoModel->buscar($nombre, $precio_min, $precio_max);
        echo json_encode($productos);
    }
}
?>
