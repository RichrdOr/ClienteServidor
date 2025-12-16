<?php
/**
 * Vista: Lista de Préstamos Activos
 * CLIENTE: Muestra los préstamos pendientes o retrasados.
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<h2>Gestión de Préstamos de Equipo</h2>

<div class="actions">
    <a href="/index.php?controller=prestamo&action=create" class="btn btn-primary">➕ Registrar Préstamo</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Equipo</th>
            <th>Miembro</th>
            <th>Fecha Préstamo</th>
            <th>Devolución Esperada</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($prestamos)): ?>
            <tr>
                <td colspan="7" class="text-center">No hay préstamos activos</td>
            </tr>
        <?php else: ?>
            <?php foreach ($prestamos as $prestamo): ?>
                <tr>
                    <td><?php echo htmlspecialchars($prestamo['id']); ?></td>
                    <td><?php echo htmlspecialchars($prestamo['equipo_name']); ?></td>
                    <td><?php echo htmlspecialchars($prestamo['member_name']); ?></td>
                    <td><?php echo htmlspecialchars($prestamo['loan_date']); ?></td>
                    <td><?php echo htmlspecialchars($prestamo['due_date']); ?></td>
                    <td>
                        <?php 
                        $badgeClass = 'success';
                        if ($prestamo['loan_status'] === 'overdue') {
                            $badgeClass = 'danger';
                        }
                        ?>
                        <span class="badge badge-<?php echo $badgeClass; ?>">
                            <?php echo htmlspecialchars($prestamo['loan_status']); ?>
                        </span>
                    </td>
                    <td class="actions-cell">
                        <a href="/index.php?controller=prestamo&action=returnLoan&id=<?php echo $prestamo['id']; ?>" 
                           class="btn btn-sm btn-info" 
                           onclick="return confirm('¿Confirma la devolución del equipo <?php echo htmlspecialchars($prestamo['equipo_name']); ?>?')">
                           Registrar Devolución
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>