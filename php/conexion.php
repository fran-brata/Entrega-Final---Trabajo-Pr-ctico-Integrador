<?php
$host = 'localhost';
$usuario = 'root';
$password = ''; // Deja vacío si no tienes contraseña
$base_datos = 'ciclop';

$conn = new mysqli($host, $usuario, $password, $base_datos);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>
