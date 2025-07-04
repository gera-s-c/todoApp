<?php

require '../db.php';

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM crud WHERE id = $id";
    $result = $con->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="/build/css/app.css">
                <title>Detalle</title>
            </head>
            <body>
                <div class="informacion">
                    <h1>Detalles del registro</h1>
                    <div class="campos">
                        <div class="campo"><strong>Nombre:</strong> <?= $row['nombre'] ?></div>
                        <div class="campo"><strong>Apellido:</strong> <?= $row['apellido'] ?></div>
                        <div class="campo"><strong>Tarea:</strong> <?= isset($row['title']) ? $row['title'] : 'No disponible' ?></div>
                        <div class="campo"><strong>Descripción:</strong> <?= isset($row['descripcion']) ? $row['descripcion'] : 'No disponible' ?></div>
                        <div class="campo"><strong>Fecha:</strong> <?= isset($row['created_at']) ? $row['created_at'] : 'No disponible' ?></div>
                    </div>
                    <a href="../index.php" class="volver">Volver</a>
                </div>
            </body>
        </html>
        <?php
    } else {
        echo "No se encontro el regristro";
    }
} else {
    echo "ID no proporcionado";
}

?>