<?php
/**
 * Vista: Crear Préstamo
 * CLIENTE: Formulario que captura los datos para enviar al SERVIDOR.
 */
require_once __DIR__ . '/../layouts/header.php';
?>

<h2>Registrar Nuevo Préstamo</h2>

<form method="POST" action="/index.php?controller=prestamo&action=store" class="form">
    
    <div class="form-group">
        <label for="equipo_id">Equipo a Prestar *</label>
        <select id="equipo_id" name="equipo_id" required 
                class="<?php echo isset($errors['equipo_id']) ? 'error' : ''; ?>">
            <option value="">-- Seleccione un Equipo Disponible --</option>
            <?php foreach ($equipos as $equipo): ?>
                <option value="<?php echo htmlspecialchars($equipo['id']); ?>"
                        <?php echo (($_POST['equipo_id'] ?? '') == $equipo['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($equipo['name']); ?> (<?php echo htmlspecialchars($equipo['serial_number']); ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['equipo_id'])): ?>
            <span class="error-message"><?php echo htmlspecialchars($errors['equipo_id']); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="user_id">Miembro Solicitante *</label>
        <select id="user_id" name="user_id" required 
                class="<?php echo isset($errors['user_id']) ? 'error' : ''; ?>">
            <option value="">-- Seleccione un Miembro --</option>
            <?php foreach ($members as $member): ?>
                <option value="<?php echo htmlspecialchars($member['id']); ?>"
                        <?php echo (($_POST['user_id'] ?? '') == $member['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($member['name']); ?> (ID: <?php echo htmlspecialchars($member['id']); ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['user_id'])): ?>
            <span class="error-message"><?php echo htmlspecialchars($errors['user_id']); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="due_date">Fecha de Devolución Esperada *</label>
        <input type="date" id="due_date" name="due_date" required 
               value="<?php echo htmlspecialchars($_POST['due_date'] ?? date('Y-m-d', strtotime('+7 days'))); ?>"
               min="<?php echo date('Y-m-d'); ?>"
               class="<?php echo isset($errors['due_date']) ? 'error' : ''; ?>">
        <?php if (isset($errors['due_date'])): ?>
            <span class="error-message"><?php echo htmlspecialchars($errors['due_date']); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Registrar Préstamo</button>
        <a href="/index.php?controller=prestamo&action=index" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>