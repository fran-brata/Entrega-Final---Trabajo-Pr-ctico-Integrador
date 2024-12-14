<?php
session_start();
require_once dirname(__DIR__) . '/php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = intval($_POST['id_producto']);
    $cantidad = intval($_POST['cantidad']);

    // Consulta el stock disponible
    $sql_stock = "SELECT stock FROM productos WHERE id = ?";
    $stmt_stock = $conn->prepare($sql_stock);
    $stmt_stock->bind_param("i", $id_producto);
    $stmt_stock->execute();
    $resultado_stock = $stmt_stock->get_result();

    if ($resultado_stock->num_rows > 0) {
        $producto = $resultado_stock->fetch_assoc();

        if ($cantidad > $producto['stock']) {
            $_SESSION['mensaje_error'] = "La cantidad solicitada excede el inventario disponible.";
        } else {
            // Añadir al carrito
            if (!isset($_SESSION['carrito'])) {
                $_SESSION['carrito'] = [];
            }

            if (isset($_SESSION['carrito'][$id_producto])) {
                $_SESSION['carrito'][$id_producto] += $cantidad;
            } else {
                $_SESSION['carrito'][$id_producto] = $cantidad;
            }

            $_SESSION['mensaje_exito'] = "Producto añadido al carrito.";
        }
    } else {
        $_SESSION['mensaje_error'] = "Producto no encontrado.";
    }

    // Regresar a la página principal sin redirección a otra ruta
    header("Location: http://localhost/pag/php/vista_cliente.php");
    exit();
}
?>
