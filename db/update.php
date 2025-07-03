<?php
require '../db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$title = '';
$error = '';
$succes = '';

if ($id > 0) {
    // Obtener datos actuales de la tarea
    $stmt = $conn->prepare("SELECT title FROM CRUD WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($title);
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
    if (!empty($newTitle)) {
        $stmt = $conn->prepare("UPDATE CRUD SET title = ? WHERE id = ?");
        $stmt->bind_param("si", $newTitle, $id);
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
        <label for="title">Título:</label><br>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($title) ?>"><br><br>
        <input type="submit" value="Actualizar">
        <a href="../index.php">Cancelar</a>
    </form>
</body>
</html>
