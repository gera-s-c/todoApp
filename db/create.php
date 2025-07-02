<?php 
    require 'db.php';

    $title = '';
    $succes = '';
    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = trim($_POST['title']);

        if (!empty($title)) {
            $stmt = $conn->prepare("INSERT INTO CRUD (title, completed) VALUES (?, 0)");
            $stmt->bind_param("s", $title);

            if ($stmt->execute()) {
                $succes = "Tarea creada con exito.";
                $title = '';
            } else {
                $error="Error al crear la tarea." . $stmt->error;
            }

            $stmt->close();
        } else {
            $error="El titulo no puede estar vacio.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Crear tarea</title>
        <style>
            body { font-family: Arial; margin: 20px;}
            input[type="text"] { width: 300px; padding: 8px;}
            input[type="submit"], a.button {
                padding: 8px 12px;
                margin-top: 10px;
                text-decoration: none;
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }
            .msg { margin: 10px; }
            .error { color: red;}
            .succes { color: green; }
        </style>
    </head>
    <body>
        
        <h2>Agregar nueva tarea</h2>
        <form method="post" action="">
            <label for="title">Titulo</label><br>
            <imput type="text" name="title" id="title" value="<?= htmlspecialchars($title) ?>"><br>
            <imput type="submit" value="Guardar">
            <a href="index.php" class="button">Volver</a>
        </form>

        <div class="msg">
            <? if($error): ?><p class="error"><?= $error ?></p><? endif; ?>
            <? if($succes): ?><p class="succes"><?= $succes ?></p><? endif; ?>
        </div>
    </body>
</html>