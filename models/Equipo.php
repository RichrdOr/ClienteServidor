<?php
/**
 * Modelo de Equipo
 * Gestiona el inventario de la tabla 'equipos'.
 */
require_once __DIR__ . '/../config/database.php';

class Equipo {
    private $db;
    
    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }
    
    // Obtiene todos los equipos (para la gestión completa)
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM equipos ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    // Obtiene solo los equipos disponibles (usado al crear un préstamo)
    public function getAllAvailable() {
        $stmt = $this->db->query("SELECT * FROM equipos WHERE status = 'available' ORDER BY name ASC");
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM equipos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Cambia el estado del equipo (a 'loaned' o 'available')
    public function updateStatus($id, $newStatus) {
        $sql = "UPDATE equipos SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'status' => $newStatus
        ]);
    }
}