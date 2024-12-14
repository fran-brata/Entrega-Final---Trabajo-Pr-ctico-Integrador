<?php  
session_start();
require_once dirname(__DIR__) . '/php/conexion.php'; // Incluye la conexión correctamente

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Mensajes de éxito/error
$mensaje = $_SESSION['mensaje'] ?? '';
unset($_SESSION['mensaje']);

// Consultar productos
$productos = [];
if (isset($conn)) { // Verifica si $conn está definido
    $sql = "SELECT * FROM productos";
    $resultado = $conn->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        while ($producto = $resultado->fetch_assoc()) {
            $productos[] = $producto;
        }
    } else {
        $mensaje = "No hay productos registrados.";
    }
} else {
    die("Error: Conexión a la base de datos no disponible.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../css/gestion_productos.css">
</head>
<body>
    <div class="product-management-container">
        <header>
            <h1>Gestión de Productos</h1>
        </header>

        <!-- Mensaje de éxito/error -->
        <?php if (!empty($mensaje)) : ?>
            <div class="mensaje">
                <p><?php echo htmlspecialchars($mensaje); ?></p>
            </div>
        <?php endif; ?>

        <!-- Formulario para agregar producto -->
        <div class="add-product-form">
            <h2>Agregar Producto</h2>
            <form action="../php/agregar_producto.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" id="nombre" name="nombre" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="form-input" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" id="precio" name="precio" class="form-input" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" class="form-input" required>
                </div>
                <div class="form-group">
                    <label for="imagen" class="form-label">Imagen del Producto</label>
                    <input type="file" id="imagen" name="imagen" class="form-input" accept="image/*">
                </div>
                <button type="submit" class="btn-submit">Agregar Producto</button>
            </form>
        </div>

        <!-- Tabla de productos -->
        <div class="product-table">
            <h2>Lista de Productos</h2>
            <?php if (!empty($productos)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($producto['id']); ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                                <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                                <td>
                                    <?php 
                                    // Ruta de la imagen
                                    $nombreImagen = htmlspecialchars($producto['imagen']);
                                    $rutaImagen = "../img/" . $nombreImagen;
                                    if (!empty($nombreImagen) && file_exists(__DIR__ . "/../img/" . $nombreImagen)) : ?>
                                        <img src="<?php echo $rutaImagen; ?>" alt="Imagen del producto" width="100" height="100">
                                    <?php else : ?>
                                        <img src="../img/imagen_defecto.jpg" alt="Imagen por defecto" width="100" height="100">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="../php/editar_producto.php?id=<?php echo $producto['id']; ?>">Editar</a> |
                                    <a href="../php/eliminar_producto.php?id=<?php echo $producto['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No hay productos registrados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
