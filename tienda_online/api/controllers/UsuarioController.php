<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new Usuario();
    }

    public function registrar() {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (empty($data['nombre']) || empty($data['email']) || empty($data['contraseña'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            return;
        }
    
        // Validar formato del email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'El email no es válido']);
            return;
        }
    
        // Validar fortaleza de la contraseña (mínimo 6 caracteres)
        if (strlen($data['contraseña']) < 6) {
            http_response_code(400);
            echo json_encode(['error' => 'La contraseña debe tener al menos 6 caracteres']);
            return;
        }
    
        $this->usuarioModel->registrar($data['nombre'], $data['email'], $data['contraseña']);
        echo json_encode(['mensaje' => 'Usuario registrado exitosamente']);
    }

    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
    
        // Verificar si los datos son válidos
        if (empty($data['email']) || empty($data['contraseña'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Email y contraseña son obligatorios']);
            return;
        }
    
        // Obtener el usuario por email
        $usuario = $this->usuarioModel->obtenerPorEmail($data['email']);
        if ($usuario && password_verify($data['contraseña'], $usuario['contraseña'])) {
            // Eliminar la contraseña de la respuesta por seguridad
            unset($usuario['contraseña']);
            echo json_encode(['mensaje' => 'Login exitoso', 'usuario' => $usuario]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales inválidas']);
        }
    }

    public function obtenerPerfil($id) {
        $usuario = $this->usuarioModel->obtenerPorId($id);
        if ($usuario) {
            // Excluir la contraseña de la respuesta
            unset($usuario['contraseña']);
            echo json_encode($usuario);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }
    
    public function actualizarPerfil($id) {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (empty($data['nombre']) || empty($data['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nombre y email son obligatorios']);
            return;
        }
    
        // Validar formato del email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'El email no es válido']);
            return;
        }
    
        $this->usuarioModel->actualizar($id, $data['nombre'], $data['email']);
        echo json_encode(['mensaje' => 'Perfil actualizado']);
    }
}
?>