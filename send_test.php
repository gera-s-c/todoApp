<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php'; // Carga automática de PHPMailer

$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP de Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'tu_correo@gmail.com';           // Reemplaza con tu Gmail
    $mail->Password   = 'tu_contraseña_de_aplicacion';   // Contraseña de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Dirección del remitente y destinatario
    $mail->setFrom('tu_correo@gmail.com', 'Nombre del Proyecto');
    $mail->addAddress('destinatario@ejemplo.com', 'Usuario'); // Reemplaza con tu correo real

    // Contenido del mensaje
    $mail->isHTML(true);
    $mail->Subject = 'Restablece tu contraseña';
    $mail->Body    = 'Haz clic aquí para restablecer tu contraseña: <a href="http://localhost/todoApp-main/reset_password.php?token=abc123">Restablecer</a>';

    $mail->send();
    echo '✅ El correo ha sido enviado exitosamente.';
} catch (Exception $e) {
    echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
}
