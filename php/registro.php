<?php 
require_once dirname(__DIR__) . '/php/conexion.php';

$error = ""; // Variable para almacenar mensajes de error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $contraseña = trim($_POST['contraseña']);
    $email = trim($_POST['email']);

    // Verificación básica del correo (solo no vacío)
    if (empty($email)) {
        $error = "El correo electrónico no puede estar vacío.";
    } else {
        // Verifica si el usuario ya existe
        $sql_verificar = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
        $stmt_verificar = $conn->prepare($sql_verificar);
        $stmt_verificar->bind_param("s", $nombre_usuario);
        $stmt_verificar->execute();
        $resultado = $stmt_verificar->get_result();

        if ($resultado->num_rows > 0) {
            $error = "El nombre de usuario ya está registrado. Por favor, elige otro.";
        } else {
            // Inserta el nuevo usuario en la base de datos
            $sql_insertar = "INSERT INTO usuarios (nombre_usuario, contraseña, email, rol) VALUES (?, ?, ?, 'usuario')";
            $stmt_insertar = $conn->prepare($sql_insertar);
            $stmt_insertar->bind_param("sss", $nombre_usuario, $contraseña, $email);

            if ($stmt_insertar->execute()) {
                // Redirige al usuario al iniciar sesión después de un registro exitoso
                header('Location: ../php/login.php?registro=exitoso');
                exit();
            } else {
                $error = "Hubo un error al registrar al usuario. Inténtalo nuevamente.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <h1>Registro de Usuario</h1>
            <p>Ingresa tus datos para crear una cuenta</p>
        </div>
        <form action="registro.php" method="POST" class="register-form">
            <?php if (!empty($error)): ?>
                <div class="error-message" style="color: #ff4d4d; margin-bottom: 15px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input 
                    type="password" 
                    id="contraseña" 
                    name="contraseña" 
                    class="form-input" 
                    required
                    minlength="4" 
                    title="Debe tener al menos 4 caracteres."
                >
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="text" id="email" name="email" class="form-input" required>
            </div>
            <button type="submit" class="btn-submit">Registrar</button>
        </form>
        <div class="register-footer">
            <p>¿Ya tienes cuenta? <a href="../php/login.php">Inicia sesión aquí</a></p>
        </div>
    </div>
</div>
</body>
</html>
