<?php

require_once dirname(__DIR__) . '/php/conexion.php';

// Verificar si se recibió un ID válido por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Obtener los datos actuales del producto
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $producto = $resultado->fetch_assoc();

        if (!$producto) {
            die('<div class="error-message">Producto no encontrado.</div>');
        }
    } else {
        die('<div class="error-message">Error al preparar la consulta: ' . $conn->error . '</div>');
    }
} else {
    die('<div class="error-message">ID de producto no válido.</div>');
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $cantidad = $_POST['cantidad'] ?? 0;

    // Actualizar el producto en la base de datos
    $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, cantidad = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $cantidad, $id);

        if ($stmt->execute()) {
            header('Location: gestion_productos.html?success=edit');
            exit();
        } else {
            die('<div class="error-message">Error al actualizar el producto: ' . $stmt->error . '</div>');
        }
    } else {
        die('<div class="error-message">Error al preparar la consulta: ' . $conn->error . '</div>');
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/editar_producto.css">
</head>
<body>
<form action="pag/php/editar_producto.php" method="POST">
        <h1>Editar Producto</h1>
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" value="<?= htmlspecialchars($producto['precio']) ?>" required>
        </div>

        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="<?= htmlspecialchars($producto['cantidad']) ?>" required>
        </div>

        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>
