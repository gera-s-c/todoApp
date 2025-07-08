<?php
require 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $completada = isset($_POST['completada']) ? 1 : 0;

    $stmt = $con->prepare("UPDATE CRUD SET completada = ? WHERE id = ?");
    $stmt->bind_param("ii", $completada, $id);
    $stmt->execute();
    $stmt->close();
} else {
    // Opcional: manejar error o no hacer nada si no hay id
    // Ejemplo: echo "Error: No se recibió el ID de la tarea.";
}

?>