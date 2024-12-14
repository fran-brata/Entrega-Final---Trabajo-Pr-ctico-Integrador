<?php 
session_start();
require_once dirname(__DIR__) . '/php/conexion.php';

$error = ""; // Inicializa el mensaje de error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Verifica si la conexión existe
    if (!isset($conn)) {
        die("Error: Conexión a la base de datos no disponible.");
    }

    // Consulta segura
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($password === $user['contraseña']) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['rol'] = $user['rol'];
                $_SESSION['usuario'] = $user['nombre_usuario'];

                if ($user['rol'] === 'admin') {
                    header('Location: gestion_productos.php');
                } elseif ($user['rol'] === 'usuario') {
                    header('Location: vista_cliente.php');
                } else {
                    $error = "Rol desconocido.";
                }
            } else {
                $error = "Contraseña incorrecta.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }

        $stmt->close();
    } else {
        $error = "Error en la consulta: " . $conn->error;
    }
}

if (isset($conn)) {
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Inicio de Sesión</h1>
                <p>Ingresa tus credenciales para continuar</p>
            </div>
            <form action="login.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" id="usuario" name="usuario" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                <button type="submit" class="btn-submit">Iniciar Sesión</button>
            </form>
            <?php if (!empty($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="login-footer">
                <p>¿No tienes una cuenta? <a href="../php/registro.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
</body>
</html>
