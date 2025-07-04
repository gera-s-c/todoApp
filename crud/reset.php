<?php
require 'db.php';

// Elimina todas las tareas
$conn->query("DELETE FROM CRUD");

// Reinicia el contador de AUTO_INCREMENT
$conn->query("ALTER TABLE CRUD AUTO_INCREMENT = 1");

// Redirige al inicio
header("Location: ../index.php");
exit;
?>
