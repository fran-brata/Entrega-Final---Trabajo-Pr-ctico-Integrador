<?php
session_start(); // Iniciar la sesión
require_once dirname(__DIR__) . '/php/conexion.php'; // Conexión a la base de datos

// Verificar si el carrito está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<script>
            alert('Tu carrito está vacío. Agrega productos antes de finalizar la compra.');
            window.location.href = 'vista_cliente.php';
          </script>";
    exit();
}

// Procesar la compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vaciar el carrito (en un entorno real, aquí guardarías los datos en la base de datos)
    unset($_SESSION['carrito']);
    echo "<script>
            alert('¡Compra realizada con éxito! Gracias por tu pedido.');
            window.location.href = 'vista_cliente.php';
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <style>
        /* Reset básico */
        * {
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

        main {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background: #1a1a1a;
            border: 1px solid #333333;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #6666ff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #333333;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #101010;
            color: #6666ff;
        }

        table td {
            background-color: #222222;
        }

        .total {
            text-align: right;
            font-size: 1.2rem;
            margin: 10px 0;
            color: #ffffff;
        }

        form {
            text-align: center;
        }

        button {
            background: linear-gradient(90deg, #4444ff, #6666ff);
            border: none;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
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
        <h1>Finalizar Compra</h1>
    </header>

    <main>
        <h2>Resumen del Pedido</h2>
        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
            <?php
            $total_general = 0;

            // Recorrer productos en el carrito
            foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
                // Obtener datos del producto
                $sql = "SELECT nombre, precio FROM productos WHERE id = $id_producto";
                $resultado = $conn->query($sql);

                if ($resultado && $producto = $resultado->fetch_assoc()) {
                    $nombre = $producto['nombre'];
                    $precio = $producto['precio'];
                    $total_producto = $precio * $cantidad;

                    echo "<tr>";
                    echo "<td>$nombre</td>";
                    echo "<td>$cantidad</td>";
                    echo "<td>$" . number_format($precio, 2) . "</td>";
                    echo "<td>$" . number_format($total_producto, 2) . "</td>";
                    echo "</tr>";

                    $total_general += $total_producto;
                }
            }
            ?>
        </table>
        <p class="total"><strong>Total a Pagar: $<?php echo number_format($total_general, 2); ?></strong></p>

        <form method="post">
            <button type="submit">Confirmar Compra</button>
        </form>
    </main>

    <footer>
        <p>© 2024 Tienda de Productos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
