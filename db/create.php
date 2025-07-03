<?php
require '../db.php';

$nombre = $apellido = $title = $descripcion = '';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $title = trim($_POST['title']);
    $descripcion = trim($_POST['descripcion']);

    if ($nombre === '' || $apellido === '' || $title === '') {
        $error = "Los campos Nombre, Apellido y Título son obligatorios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO CRUD (nombre, apellido, title, descripcion, completed) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("ssss", $nombre, $apellido, $title, $descripcion);

        if ($stmt->execute()) {
            // **Aquí va la redirección para ir a index.php después de guardar**
            header("Location: ../index.php");
            exit;
        } else {
            $error = "Error al crear la tarea: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="src/css/app.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <title class="nuevo">Crear nueva tarea</title>
        <style>
            body { font-family: Arial; margin: 20px;}
            input[type="text"], textarea { width: 300px; padding: 8px; margin-bottom: 10px;}
            input[type="submit"], a.button {
                padding: 8px 12px;
                margin-top: 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
            }
            .msg { margin: 10px 0; }
            .error { color: red; }
            .success { color: green; }
        </style>
    </head>
    <body>

    <div class="contenedor-create">
        <h2>Crear nueva tarea</h2>

        <form method="post" action="create.php" class="cuadro">
            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>"><br>

            <label for="apellido">Apellido:</label><br>
            <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($apellido) ?>"><br>

            <label for="title">Tarea a desarrollar (Título):</label><br>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($title) ?>"><br>

            <label for="descripcion">Descripción:</label><br>
            <textarea name="descripcion" id="descripcion" rows="4"><?= htmlspecialchars($descripcion) ?></textarea><br>

            <input type="submit" value="Guardar">

        </form>
    </div>
    <div class="msg">
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php elseif ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
    </div>

    </body>
</html>
