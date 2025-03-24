<?php
require_once __DIR__ . '/../config/db.php';

class Usuario {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function registrar($nombre, $email, $contraseña) {
        $hashed_password = password_hash($contraseña, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $email, $hashed_password]);
    }

    public function obtenerPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $email) {
        $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
        $stmt->execute([$nombre, $email, $id]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function obtenerTodos() {
        $stmt = $this->conn->query("SELECT id, nombre, email FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>