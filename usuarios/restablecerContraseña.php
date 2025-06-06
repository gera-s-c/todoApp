<?php
session_start();
require_once 'db.php';

$message = '';
$token = $_GET['token'] ?? ''; // Obtener el token de la URL

if (empty($token)) {
    $message = '<p style="color: red;">Token de restablecimiento inválido o faltante.</p>';
} else {
    // --- Buscar usuario por token y verificar expiración ---
    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $message = '<p style="color: red;">El enlace de restablecimiento no es válido o ha expirado.</p>';
        $token = ''; // Invalidar el token para que no se muestre el formulario
    } else {
        $user = $result->fetch_assoc();
        $_SESSION['reset_user_id'] = $user['id']; // Almacenar ID del usuario para el restablecimiento
    }
    $stmt->close();
}

// --- Manejar el formulario de restablecimiento ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    $new_password = $_POST['password'];
    $confirm_new_password = $_POST['confirm_password'];
    $current_token = $_POST['token_field']; // Obtener el token del campo oculto

    if (empty($new_password) || empty($confirm_new_password)) {
        $message = '<p style="color: red;">Por favor, ingresa y confirma tu nueva contraseña.</p>';
    } elseif ($new_password !== $confirm_new_password) {
        $message = '<p style="color: red;">Las contraseñas no coinciden.</p>';
    } elseif (strlen($new_password) < 6) {
        $message = '<p style="color: red;">La contraseña debe tener al menos 6 caracteres.</p>';
    } else {
        // Re-verificar el token y el usuario para evitar ataques de repetición
        $stmt_check_again = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires_at > NOW()");
        $stmt_check_again->bind_param("s", $current_token);
        $stmt_check_again->execute();
        $result_check_again = $stmt_check_again->get_result();

        if ($result_check_again->num_rows == 1) {
            $user_id_to_reset = $result_check_again->fetch_assoc()['id'];
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Actualizar contraseña y limpiar token/expiración
            $stmt_update_pass = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires_at = NULL WHERE id = ?");
            $stmt_update_pass->bind_param("si", $hashed_new_password, $user_id_to_reset);

            if ($stmt_update_pass->execute()) {
                $message = '<p style="color: green;">¡Contraseña restablecida con éxito! Ya puedes iniciar sesión.</p>';
                $token = ''; // Limpiar el token para evitar reenvíos
                // Redirigir al login después de un breve momento
                header("Refresh: 3; URL=inisioSecion.php");
            } else {
                $message = '<p style="color: red;">Error al restablecer la contraseña.</p>';
            }
            $stmt_update_pass->close();
        } else {
            $message = '<p style="color: red;">El enlace de restablecimiento ya no es válido. Solicita uno nuevo.</p>';
        }
        $stmt_check_again->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="/usuarios/estilo.css">
</head>
<body>
    <div class="container">
        <h2>Restablecer Contraseña</h2>
        <?php echo $message; ?>

        <?php if (!empty($token) && !isset($_POST['password'])): // Muestra el formulario solo si el token es válido y no se ha enviado el formulario ?>
        <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
            <input type="hidden" name="token_field" value="<?php echo htmlspecialchars($token); ?>">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="confirm_password">Confirmar Nueva Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>

            <button type="submit">Restablecer Contraseña</button>
        </form>
        <?php endif; ?>

        <p><a href="/usuarios/inicioSesion.php">Volver al Inicio de Sesión</a></p>
    </div>
</body>
</html>