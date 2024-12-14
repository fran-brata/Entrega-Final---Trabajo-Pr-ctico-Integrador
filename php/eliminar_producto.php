<?php
session_start();
require_once dirname(__DIR__) . '/php/conexion.php';

// Verificar si la conexión existe y es válida
if (!$conn || $conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si el usuario es un administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['mensaje'] = "Acceso denegado.";
    header('Location: ../php/gestion_productos.php');
    exit();
}

// Verificar si se ha enviado el ID del producto
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegurar que el ID sea un entero

    // Preparar la consulta para eliminar el producto
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Producto eliminado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al eliminar el producto.";
        }

        $stmt->close();
    } else {
        $_SESSION['mensaje'] = "Error al preparar la consulta.";
    }

    $conn->close();

    // Redirigir a la página de gestión de productos
    header('Location: ../php/gestion_productos.php');
    exit();
} else {
    $_SESSION['mensaje'] = "No se proporcionó un ID de producto válido.";
    header('Location: ../php/gestion_productos.php');
    exit();
}
?>
