<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';
require 'usuarios/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verificar si el email existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        // Generar token y expiración
        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $user_id = $usuario['id'];

        // Guardar token
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $token, $expira);
        $stmt->execute();

        // Enviar correo con PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tu_correo@gmail.com';            // Tu Gmail
            $mail->Password   = 'tu_contraseña_de_aplicacion';    // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('tu_correo@gmail.com', 'TodoApp');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body    = 'Haz clic aquí para restablecer tu contraseña: <br>
                <a href="http://localhost/todoApp-main/reset_password.php?token=' . $token . '">Restablecer contraseña</a>';

            $mail->send();
            echo "✅ Se envió el enlace de recuperación a tu correo.";
        } catch (Exception $e) {
            echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ El correo no está registrado.";
    }
}
