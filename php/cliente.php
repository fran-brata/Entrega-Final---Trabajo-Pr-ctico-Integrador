<?php
// Consulta de productos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while ($producto = $resultado->fetch_assoc()) {
        echo "<div class='product-item'>";
        echo "<img src='http://localhost/pag/" . $producto['imagen'] . "' alt='" . $producto['nombre'] . "'>";
        echo "<h3>" . $producto['nombre'] . "</h3>";
        echo "<p>" . $producto['descripcion'] . "</p>";
        echo "<p><strong>Precio: $" . number_format($producto['precio'], 2) . "</strong></p>";
        echo "<p><strong>Disponibles: " . $producto['stock'] . "</strong></p>"; // Muestra el stock disponible

        if (isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id'])) {
            // Mostrar formulario para añadir al carrito si el usuario está logueado
            echo "<form method='post' action='http://localhost/pag/php/carrito.php'>";
            echo "<input type='hidden' name='id_producto' value='" . $producto['id'] . "'>";
            echo "<label for='cantidad_" . $producto['id'] . "'>Cantidad:</label>";
            echo "<input type='number' id='cantidad_" . $producto['id'] . "' name='cantidad' min='1' max='" . $producto['stock'] . "' value='1' required>"; // Establece el máximo al stock disponible
            echo "<button type='submit'>Añadir al carrito</button>";
            echo "</form>";
        } else {
            // Mostrar solo información y mensaje si el usuario no está logueado
            echo "<p style='color: #6666ff;'>Inicia sesión para añadir este producto al carrito.</p>";
        }

        echo "</div>";
    }
} else {
    echo "<p class='mensaje-error'>No hay productos disponibles.</p>";
}
?>
