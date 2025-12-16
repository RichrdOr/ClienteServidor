<?php
/**
 * Modelo de Préstamo
 * Gestiona la tabla 'prestamos' y la lógica de las transacciones.
 */
require_once __DIR__ . '/../config/database.php';

class Prestamo {
    private $db;
    
    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }
    
    // Lista los préstamos activos y con estado 'overdue'
    public function getAllActive() {
        // Unir con equipos y miembros para mostrar nombres
        $sql = "SELECT p.*, e.name AS equipo_name, m.name AS member_name
                FROM prestamos p
                JOIN equipos e ON p.equipo_id = e.id
                JOIN members m ON p.user_id = m.id 
                WHERE p.loan_status = 'active' OR p.loan_status = 'overdue'
                ORDER BY p.loan_date DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM prestamos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Crea un nuevo registro de préstamo.
     */
    public function create($data) {
        $sql = "INSERT INTO prestamos (equipo_id, user_id, due_date) 
                VALUES (:equipo_id, :user_id, :due_date)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'equipo_id' => $data['equipo_id'],
            'user_id' => $data['user_id'],
            'due_date' => $data['due_date']
        ]);
        return $this->db->lastInsertId();
    }
    
    /**
     * Registra la devolución de un préstamo.
     */
    public function completeReturn($id) {
        $sql = "UPDATE prestamos 
                SET return_date = CURRENT_DATE, loan_status = 'returned'
                WHERE id = :id AND loan_status != 'returned'";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}