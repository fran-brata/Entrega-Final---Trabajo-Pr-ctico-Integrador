<?php
// Incluir conexión a la base de datos
require_once dirname(__DIR__) . '/php/conexion.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $precio = $_POST['precio'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;

    // Validar que no haya campos vacíos
    if (!empty($nombre) && !empty($descripcion) && !empty($precio) && !empty($cantidad)) {
        // Verificar si la conexión está activa
        if (!$conn || $conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Preparar la consulta para insertar el producto
        $sql = "INSERT INTO productos (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $cantidad);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir con mensaje de éxito
                header('Location: gestion_productos.php?mensaje=Producto agregado exitosamente');
                exit();
            } else {
                // Redirigir con mensaje de error al ejecutar
                header('Location: gestion_productos.php?mensaje=Error al agregar el producto');
                exit();
            }

            $stmt->close(); // Cerrar la consulta preparada
        } else {
            die("Error al preparar la consulta: " . $conn->error);
        }

        $conn->close(); // Cerrar la conexión
    } else {
        // Redirigir si faltan campos
        header('Location: gestion_productos.php?mensaje=Todos los campos son obligatorios');
        exit();
    }
}
?>
