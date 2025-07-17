<?php
    require '../db.php';

    $nombre = $apellido = $title = $descripcion = '';
    $completada = 0;
    $success = '';
    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title']);
        $estado_input = $_POST['estado'] ?? 'pendiente'; // valor por defecto

        // Convertir estado a 0 o 1
        if (strtolower($estado_input) === 'completada') {
            $completed = 1;
        } else {
            $completed = 0;
        }

        if (!$title) {
            $error = 'Por favor completa el título.';
        } else {
            $sql = "INSERT INTO crud (title, completada) VALUES (?, ?)";
            $stmt = $con->prepare($sql);

            if ($stmt === false) {
                $error = "Error en la preparación: " . $con->error;
            } else {
                $stmt->bind_param("si", $title, $completada);

                if ($stmt->execute()) {
                    header('Location: ../index.php');
                    exit(); // Muy importante para detener la ejecución
                } else {
                    $error = "Error al insertar: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }

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
        <link rel="stylesheet" href="/build/css/app.css">
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

    <div class="contenedor-tarea">
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
        <label for="estado">Estado:</label><br>
        <select name="estado" id="estado">
            <option value="1" <?= ($completada == 1) ? 'selected' : '' ?>>Iniciada</option>
            <option value="2" <?= ($completada == 2) ? 'selected' : '' ?>>En proceso</option>
            <option value="3" <?= ($completada == 3) ? 'selected' : '' ?>>Completada</option>
        </select><br>
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
