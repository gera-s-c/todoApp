<?php
    require '../db.php';
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $nombre = '';
    $apellido = '';
    $title = '';
    $descripcion = '';
    $completada = 1;
    $error = '';
    $success = '';
    
    if ($id > 0) {
    $stmt = $con->prepare("SELECT title, nombre, apellido, completada, descripcion FROM CRUD WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($title, $nombre, $apellido, $completada, $descripcion);
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
    $descripcion = trim($_POST['descripcion']);
    $newEstado = intval($_POST['estado']);

    if (!empty($newTitle)) {
        $stmt = $con->prepare("UPDATE CRUD SET title = ?, nombre = ?, apellido = ?, completada = ?, descripcion = ? WHERE id = ?");
        $stmt->bind_param("sssisi", $newTitle, $newNombre, $newApellido, $newEstado, $descripcion, $id);
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

            <form method="post">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>"><br><br>

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($apellido) ?>"><br><br>

                <label for="title">Título</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($title) ?>"><br><br>

                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="4"><?= htmlspecialchars($descripcion) ?></textarea><br><br>

                <label for="estado">Estado</label>
                <select name="estado" id="estado">
                <option value="1" <?= $completada == 1 ? 'selected' : '' ?>>Iniciada</option>
                <option value="2" <?= $completada == 2 ? 'selected' : '' ?>>En proceso</option>
                <option value="3" <?= $completada == 3 ? 'selected' : '' ?>>Completada</option>
            </select><br><br>

            <input type="submit" value="Actualizar">
            <a href="../index.php">Cancelar</a>
        </form>
    </body>
</html>
