<?php
/**
 * Controlador de Préstamos
 * Maneja las peticiones del CLIENTE y coordina los Modelos (Servidor).
 */
require_once __DIR__ . '/../models/Prestamo.php';
require_once __DIR__ . '/../models/Equipo.php';
require_once __DIR__ . '/../models/Member.php'; // Para obtener la lista de miembros

class PrestamoController {
    private $prestamoModel;
    private $equipoModel;
    private $memberModel;
    
    public function __construct() {
        $this->prestamoModel = new Prestamo();
        $this->equipoModel = new Equipo();
        $this->memberModel = new Member(); 
    }
    
    // Muestra la lista de préstamos activos (GET)
    public function index() {
        $prestamos = $this->prestamoModel->getAllActive();
        require_once __DIR__ . '/../views/prestamos/index.php';
    }
    
    // Muestra el formulario para crear un préstamo (GET)
    public function create() {
        $equipos = $this->equipoModel->getAllAvailable(); // Solo equipos disponibles
        $members = $this->memberModel->getAll(); // Todos los miembros/usuarios
        $errors = [];
        require_once __DIR__ . '/../views/prestamos/create.php';
    }
    
    // Almacena un nuevo préstamo (POST)
    public function store() {
        $errors = $this->validate($_POST);
        
        if (empty($errors)) {
            $equipoId = $_POST['equipo_id'];

            // SERVIDOR: Ejecuta la lógica transaccional
            $this->prestamoModel->create($_POST);
            $this->equipoModel->updateStatus($equipoId, 'loaned');
            
            header('Location: /index.php?controller=prestamo&action=index&success=loan_created');
            exit;
        }
        
        // Si hay errores, recarga el formulario
        $equipos = $this->equipoModel->getAllAvailable();
        $members = $this->memberModel->getAll();
        require_once __DIR__ . '/../views/prestamos/create.php';
    }
    
    // Registra la devolución de un equipo (GET)
    public function returnLoan() {
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /index.php?controller=prestamo&action=index&error=not_found');
            exit;
        }
        
        $prestamo = $this->prestamoModel->getById($id);

        if (!$prestamo || $prestamo['loan_status'] === 'returned') {
            header('Location: /index.php?controller=prestamo&action=index&error=already_returned');
            exit;
        }

        $equipoId = $prestamo['equipo_id'];

        // SERVIDOR: Ejecuta la lógica transaccional de devolución
        $this->prestamoModel->completeReturn($id);
        $this->equipoModel->updateStatus($equipoId, 'available');

        header('Location: /index.php?controller=prestamo&action=index&success=returned');
        exit;
    }
    
    /**
     * SERVIDOR: Valida los datos recibidos.
     */
    private function validate($data) {
        $errors = [];
        
        if (empty($data['equipo_id'])) {
            $errors['equipo_id'] = 'Debe seleccionar un equipo.';
        }
        
        if (empty($data['user_id'])) {
            $errors['user_id'] = 'Debe seleccionar el miembro solicitante.';
        }

        if (empty($data['due_date'])) {
            $errors['due_date'] = 'La fecha de devolución es requerida.';
        } else if (strtotime($data['due_date']) < strtotime(date('Y-m-d'))) {
             $errors['due_date'] = 'La fecha de devolución debe ser futura o igual a hoy.';
        }
        
        return $errors;
    }
}
