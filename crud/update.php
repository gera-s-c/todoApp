<?php
require '../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$nombre = '';
$apellido = '';
$title = '';
$error = '';
$succes = '';

if ($id > 0) {
    // Obtener datos actuales de la tarea
    $stmt = $con->prepare("SELECT title, nombre, apellido FROM CRUD WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($title, $nombre, $apellido);
    if (!$stmt->fetch()) {
        $error = "Tarea no encontrada.";
    }
    $stmt->close();
} else {
    $error = "ID inválido.";
}

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newTitle = trim($_POST['title']);
    $newNombre = trim($_POST['nombre']);
    $newApellido = trim($_POST['apellido']);
    if (!empty($newTitle)) {
        $stmt = $con->prepare("UPDATE CRUD SET title = ?, nombre = ?, apellido = ? WHERE id = ?");
        $stmt->bind_param("sssi", $newTitle, $newNombre, $newApellido, $id);
        if ($stmt->execute()) {
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Error al actualizar la tarea: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "El título no puede estar vacío.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Editar tarea</title>
    </head>
    <body>
        <h2>Editar tarea</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

            <form method="post" action="cambiarEstado.php">

        <form method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" ><br><br>
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" ><br><br>
            <label for="title">Título</label>
            <input type="text" name="title" id="title" ><br><br>
            <input type="submit" value="Actualizar">
            <a href="../index.php">Cancelar</a>
        </form>

    </body>
</html>
