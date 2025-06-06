<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigirlo al login
if (!isset($_SESSION['user_id'])) {
    header("Location: inicioSesion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>autenticarUsuario</title>
    <link rel="stylesheet" href="/usuarios/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>!</h2>
        <p>Has iniciado sesión exitosamente.</p>
        <p><a href="/usuarios/cierreSesion.php">Cerrar Sesión</a></p>
        </div>
</body>
</html>
