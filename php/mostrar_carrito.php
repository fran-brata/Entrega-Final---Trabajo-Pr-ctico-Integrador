<?php
session_start();
require_once dirname(__DIR__) . '/php/conexion.php';

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    $carrito_vacio = true;
} else {
    $carrito_vacio = false;
    $total = 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Reset básico */
        body, h1, h2, p, ul, li, a, img, input, button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #000000, #1a1a1a);
            color: #ffffff;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        header {
            background: #101010;
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #6666ff;
        }

        header h1 {
            color: #ffffff;
            font-size: 2rem;
        }

        header nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }

        header nav ul li a {
            text-decoration: none;
            color: #6666ff;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        header nav ul li a:hover {
            color: #8888ff;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        main h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .carrito-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .carrito-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #1a1a1a;
            border: 1px solid #333333;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        .carrito-item img {
            width: 80px;
            border-radius: 10px;
        }

        .carrito-item .detalles {
            flex: 1;
            margin-left: 15px;
        }

        .carrito-item h3, p {
            margin: 0;
            color: #ffffff;
        }

        .carrito-item strong {
            color: #ffffff;
            font-size: 1.1rem;
        }

        .total {
            text-align: right;
            font-size: 1.5rem;
            color: #ffffff;
            margin-top: 20px;
        }

        button.finalizar {
            padding: 10px 20px;
            background: linear-gradient(90deg, #4444ff, #6666ff);
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button.finalizar:hover {
            background: linear-gradient(90deg, #6666ff, #8888ff);
        }

        footer {
            background: #101010;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
            border-top: 2px solid #6666ff;
        }

        footer p {
            color: #b3b3b3;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>Carrito de Compras</h1>
        <nav>
            <ul>
                <li><a href="http://localhost/pag/php/index.php">Volver a la tienda</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Tu Carrito</h2>
        <div class="carrito-container">
            <?php
            if ($carrito_vacio) {
                echo "<p>Tu carrito está vacío.</p>";
            } else {
                foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
                    // Consultar producto por ID
                    $sql = "SELECT nombre, precio, imagen FROM productos WHERE id = $id_producto";
                    $resultado = $conn->query($sql);
                    $producto = $resultado->fetch_assoc();

                    $subtotal = $producto['precio'] * $cantidad;
                    $total += $subtotal;

                    echo "<div class='carrito-item'>";
                    echo "<img src='http://localhost/pag/" . $producto['imagen'] . "' alt='" . $producto['nombre'] . "'>";
                    echo "<div class='detalles'>";
                    echo "<h3>" . $producto['nombre'] . "</h3>";
                    echo "<p>Cantidad: $cantidad</p>";
                    echo "<p>Precio Unitario: $" . number_format($producto['precio'], 2) . "</p>";
                    echo "<strong>Subtotal: $" . number_format($subtotal, 2) . "</strong>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "<div class='total'><strong>Total: $" . number_format($total, 2) . "</strong></div>";
                echo "<button class='finalizar' onclick='finalizarCompra()'>Finalizar Compra</button>";
            }
            ?>
        </div>
    </main>

    <footer>
        <p>© 2024 Tienda de Productos. Todos los derechos reservados.</p>
    </footer>

    <script>
        function finalizarCompra() {
            const tarjeta = prompt('Ingresa tu número de tarjeta para finalizar la compra:');
            if (tarjeta) {
                alert('Gracias por tu compra. ¡Vuelve pronto!');
                fetch('http://localhost/pag/php/finalizar_compra.php', { method: 'POST' })
                    .then(() => location.reload());
            }
        }
    </script>
</body>
</html>
