<?php
session_start();

// Incluye el archivo de conexión a la base de datos
require_once dirname(__DIR__) . '/php/conexion.php';

// Verifica si la conexión se estableció correctamente
if (!$conn) {
    die("Error al conectar con la base de datos.");
}

// Obtener productos destacados
$destacados = [];
$sql = "SELECT * FROM productos WHERE destacado = 1 LIMIT 6";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $destacados[] = $row;
    }
}

// Mostrar el archivo HTML (separado)
include '../index.html';
?>
