<?php
session_start(); // Inicia la sesión de PHP en cada página que la use
require_once 'db.php'; // Incluye tu conexión a la base de datos

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- Validación de Inputs ---
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = '<p style="color: red;">Todos los campos son obligatorios.</p>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '<p style="color: red;">Formato de email inválido.</p>';
    } elseif ($password !== $confirm_password) {
        $message = '<p style="color: red;">Las contraseñas no coinciden.</p>';
    } elseif (strlen($password) < 6) {
        $message = '<p style="color: red;">La contraseña debe tener al menos 6 caracteres.</p>';
    } else {
        // --- Verificar si el email ya existe ---
        $stmt_check_email = $conn->prepare("SELECT id FROM usuarios WHERE usuario_email = ?");
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $stmt_check_email->store_result();

        if ($stmt_check_email->num_rows > 0) {
            $message = '<p style="color: red;">Este email ya está registrado.</p>';
        } else {
            // --- Hashear la contraseña y guardar en la base de datos ---
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $created_at = date('Y-m-d H:i:s');

            $stmt_insert = $conn->prepare("INSERT INTO usuarios (usuario_nombre, usuario_email, usuario_contraseña, created_at) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $name, $email, $hashed_password, $created_at);

            if ($stmt_insert->execute()) {
                $message = '<p style="color: green;">¡Registro exitoso! Ahora puedes iniciar sesión.</p>';
                // Opcional: Redirigir al login después de un registro exitoso
                // header("Location: login.php");
                // exit();
            } else {
                $message = '<p style="color: red;">Error al registrar: ' . $stmt_insert->error . '</p>';
            }
            $stmt_insert->close();
        }
        $stmt_check_email->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="/usuarios/estilo.css"> </head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <?php echo $message; ?>
        <form action="/usuarios/registro.php" method="POST">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>

            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="inicioSesion.php">Iniciar Sesión</a></p>
    </div>
</body>
</html>