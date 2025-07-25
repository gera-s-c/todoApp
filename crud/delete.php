<?php
require '../db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Eliminar la tarea
    $stmt = $con->prepare("DELETE FROM CRUD WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Verificar si ya no quedan tareas
    $result = $con->query("SELECT COUNT(*) as total FROM CRUD");
    $row = $result->fetch_assoc();

    if ($row['total'] == 0) {
        // Si está vacío, reiniciar contador
        $con->query("ALTER TABLE CRUD AUTO_INCREMENT = 1");
    }

    header("Location: ../index.php");
    exit;
}
