<?php
session_start(); // Inicia la sesión
require_once dirname(__DIR__) . '/php/conexion.php'; // Conexión a la base de datos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <link rel="stylesheet" href="http://localhost/pag/css/vista_clientes.css">
</head>
<body>
    <header>
        <h1>Tienda de Productos</h1>
        <nav>
            <ul>
                <li><a href="http://localhost/pag/php/index.php">Volver al inicio</a></li>
                <li><a href="http://localhost/pag/php/mostrar_carrito.php">
                        Carrito 
                        <?php 
                        $total_productos = isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0;
                        echo "<span style='color: #6666ff;'>($total_productos)</span>";
                        ?>
                    </a>
                </li>
                <?php if (!isset($_SESSION['usuario_id'])): ?>
                    <li><a href="http://localhost/pag/php/login.php">Iniciar Sesión</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Nuestros Productos</h2>

        <!-- Mostrar notificaciones -->
        <?php if (isset($_SESSION['mensaje_exito'])): ?>
            <div class="notificacion exito">
                <?php echo $_SESSION['mensaje_exito']; unset($_SESSION['mensaje_exito']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['mensaje_error'])): ?>
            <div class="notificacion error">
                <?php echo $_SESSION['mensaje_error']; unset($_SESSION['mensaje_error']); ?>
            </div>
        <?php endif; ?>

        <div class="product-container">
            <?php
            $sql = "SELECT * FROM productos";
            $resultado = $conn->query($sql);

            if ($resultado->num_rows > 0) {
                while ($producto = $resultado->fetch_assoc()) {
                    echo "<div class='product-item'>";
                    echo "<img src='http://localhost/pag/" . $producto['imagen'] . "' alt='" . $producto['nombre'] . "'>";
                    echo "<h3>" . $producto['nombre'] . "</h3>";
                    echo "<p>" . $producto['descripcion'] . "</p>";
                    echo "<p><strong>Precio: $" . number_format($producto['precio'], 2) . "</strong></p>";
                    echo "<p><strong>Disponibles: " . $producto['stock'] . "</strong></p>";

                    if (isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id'])) {
                        echo "<form method='post' action='http://localhost/pag/php/carrito.php'>";
                        echo "<input type='hidden' name='id_producto' value='" . $producto['id'] . "'>";
                        echo "<label for='cantidad_" . $producto['id'] . "'>Cantidad:</label>";
                        echo "<input type='number' id='cantidad_" . $producto['id'] . "' name='cantidad' min='1' max='" . $producto['stock'] . "' value='1' required>";
                        echo "<button type='submit'>Añadir al carrito</button>";
                        echo "</form>";
                    } else {
                        echo "<p style='color: #6666ff;'>Inicia sesión para añadir este producto al carrito.</p>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p class='mensaje-error'>No hay productos disponibles.</p>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>© 2024 Tienda de Productos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
