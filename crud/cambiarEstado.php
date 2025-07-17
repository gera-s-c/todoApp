<?php
require '../db.php';

// Obtener lista de tareas
$result = $con->query("SELECT id, title, completada FROM crud");

// Función para mostrar texto legible del estado
function estadoTexto($code) {
    return match($code) {
        1 => 'Iniciada',
        2 => 'En proceso',
        3 => 'Completada',
        default => 'Desconocido',
    };
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar estado de tarea</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        select, input[type="submit"] {
            padding: 6px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<h2>Cambiar estado de una tarea</h2>

<form method="post" action="procesar_cambio_estado.php">
    <label for="id_tarea">Selecciona una tarea:</label><br>
    <select name="id_tarea" id="id_tarea" required>
        <option value="">-- Elige una tarea --</option>
        <?php while ($row = $result->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>">
                <?= "ID: {$row['id']} - " . htmlspecialchars($row['title']) . " (" . estadoTexto($row['completada']) . ")" ?>
            </option>
        <?php endwhile; ?>
    </select><br>

    <label for="nuevo_estado">Nuevo estado:</label><br>
    <select name="nuevo_estado" id="nuevo_estado" required>
        <option value="1">Iniciada</option>
        <option value="2">En proceso</option>
        <option value="3">Completada</option>
    </select><br>

    <input type="submit" value="Actualizar estado">
</form>

<a href="../index.php">← Volver al inicio</a>

</body>
</html>
