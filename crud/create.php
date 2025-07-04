<?php
require '../db.php';

$nombre = $apellido = $title = $descripcion = $estado = $fecha = '';
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $title = trim($_POST['title']);
    $descripcion = trim($_POST['descripcion']);
    $estado = 'P'; // pendiente



     // Si recibes un texto, conviértelo a un valor válido
    $estado_input = $_POST['estado']; // por ejemplo, "pendiente"
    
    if (strtolower($estado_input) == 'pendiente') {
        $estado = 'P';
    } elseif (strtolower($estado_input) == 'completado') {
        $estado = 'C';
    } else {
        $estado = 'P'; // valor por defecto o manejar error
    }
    
    $stmt->close();


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
        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="Iniciado">Iniciado</option>
            <option value="En proceso">En proceso</option>
            <option value="Completado">Completado</option>
        </select>
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
