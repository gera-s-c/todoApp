<?php
session_start();
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // --- Validación básica ---
    if (empty($email) || empty($password)) {
        $message = '<p style="color: red;">Por favor, ingresa tu email y contraseña.</p>';
    } else {
        // --- Buscar usuario por email ---
        $stmt = $conn->prepare("SELECT id, usuario_nombre, usuario_email, usuario_contraseña FROM usuarios WHERE usuario_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // --- Verificar contraseña hasheada ---
            if (password_verify($password, $user['usuario_contraseña'])) {
                // Contraseña correcta: iniciar sesión del usuario
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['usuario_nombre'];
                $_SESSION['user_email'] = $user['usuario_email'];

                header("Location: ../index.php"); // Redirige a la página de dashboard
                exit();
            } else {
                $message = '<p style="color: red;">Contraseña incorrecta.</p>';
            }
        } else {
            $message = '<p style="color: red;">Email no registrado.</p>';
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/usuarios/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <?php echo $message; ?>
        <form action="/usuarios/inicioSesion.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Entrar</button>
        </form>
        <p>¿No tienes una cuenta? <a href="registro.php">Registrarse</a></p>
        <p><a href="forgot_password.php">¿Olvidaste tu contraseña?</a></p>
    </div>
</body>
</html>
