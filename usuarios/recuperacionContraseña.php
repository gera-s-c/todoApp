<?php
session_start();
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '<p style="color: red;">Por favor, ingresa un email válido.</p>';
    } else {
        // --- Buscar usuario por email ---
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $user_id = $user['id'];

            // --- Generar token único y establecer fecha de expiración ---
            $token = bin2hex(random_bytes(32)); // Genera un token aleatorio
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // Expira en 1 hora

            // --- Guardar token en la base de datos ---
            $stmt_update = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires_at = ? WHERE id = ?");
            $stmt_update->bind_param("ssi", $token, $expires_at, $user_id);
            $stmt_update->execute();
            $stmt_update->close();

            // --- Enviar email con el enlace de restablecimiento ---
            $reset_link = "http://localhost/tu_proyecto/reset_password.php?token=" . $token; // CAMBIA 'tu_proyecto' por tu ruta real
            $subject = "Restablece tu contraseña";
            $body = "Haz clic en el siguiente enlace para restablecer tu contraseña: " . $reset_link;
            $headers = "From: no-reply@tuproyecto.com"; // CAMBIA esto por un email real

            // Nota: Para enviar correos con PHP se necesita configurar un servidor SMTP.
            // Para desarrollo, puedes usar MailHog con Laragon.
            // Para producción, un servicio como SendGrid o Mailgun.
            if (mail($email, $subject, $body, $headers)) {
                $message = '<p style="color: green;">Se ha enviado un enlace de restablecimiento a tu email.</p>';
            } else {
                $message = '<p style="color: red;">Error al enviar el email. Por favor, intenta de nuevo.</p>';
            }
        } else {
            $message = '<p style="color: red;">Si tu email está registrado, recibirás un enlace de restablecimiento.</p>';
            // Mensaje genérico por seguridad, para no revelar si el email existe o no
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
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="/usuarios/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Recuperar Contraseña</h2>
        <?php echo $message; ?>
        <form action="forgot_password.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <button type="submit">Enviar Enlace de Restablecimiento</button>
        </form>
        <p><a href="/usuarios/inicioSesion.php">Volver al Inicio de Sesión</a></p>
    </div>
</body>
</html>