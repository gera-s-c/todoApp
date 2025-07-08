<?php
include '../db.php';  // ruta según tu estructura

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $completada = isset($_POST['completada']) ? 1 : 0;

    $stmt = $con->prepare("UPDATE CRUD SET completada = ? WHERE id = ?");
    $stmt->bind_param("ii", $completada, $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: ../index.php");
exit;
