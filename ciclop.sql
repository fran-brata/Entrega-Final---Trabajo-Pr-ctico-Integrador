-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2024 a las 21:49:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ciclop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `destacado` tinyint(1) DEFAULT 0,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `destacado`, `cantidad`) VALUES
(3, 'Buzo ANGELS', 'Buzo de algodón, color blanco, disponible en todos los talles', 25000.00, 8, 'img/buzo3.jpg', 0, 0),
(4, 'Buzo ONLY NEED THE CREW PLUS ME', 'Buzo de algodón, color blanco, disponible en todos los talles', 30000.00, 5, 'img/buzo4.jpg', 0, 0),
(5, 'Jeans 1', 'Jeans clásicos azul oscuro', 40000.00, 20, 'img/jeans1.jpg', 0, 0),
(6, 'Jeans 2', 'Jeans cargo con bolsillos', 45000.00, 10, 'img/jeans2.jpg', 0, 0),
(7, 'Zapatillas 1', 'Zapatillas deportivas blancas', 50000.00, 12, 'img/zapatillas1.jpg', 0, 0),
(8, 'Zapatillas 2', 'Zapatillas marrones casuales', 67000.00, 8, 'img/zapatillas6.jpg', 0, 0),
(9, 'Buzo MOON', 'Buzo de algodón, color beige, disponible en todos los talles', 26000.00, 10, 'img/buzo5.jpg', 0, 0),
(10, 'Buzo MENTAL HEALTH', 'Buzo de algodón, color blanco, disponible en todos los talles', 23000.00, 15, 'img/buzo6.jpg', 0, 0),
(11, 'Buzo THE WORLD', 'Buzo oversize color azul, disponible en todos los talles', 25000.00, 8, 'img/buzo7.jpg', 0, 0),
(12, 'Buzo AMSTERDAM', 'Buzo sin capucha para mujer, disponible en todos los talles', 31000.00, 5, 'img/buzo8.jpg', 0, 0),
(13, 'Buzo ITS OK TO DO YOU', 'Buzo de algodón, color blanco, disponible en todos los talles', 32000.00, 5, 'img/buzo9.jpg', 0, 0),
(14, 'Jeans ajustado mujer', 'Disponible en todos los talles, solamente en color baige', 43000.00, 10, 'img/jeans4.jpg', 0, 0),
(15, 'Jeans ajustado hombre', 'Disponible en todos los talles, solamente en color negro', 43000.00, 10, 'img/jeans4.jpg', 0, 0),
(16, 'Jeans anchos', 'Disponible en todos los talles, solamente en color negro', 50000.00, 10, 'img/jeans5.jpg', 0, 0),
(17, 'Zapatillas ADIDAS', 'Solamente disponibles en color blanco/negro', 67000.00, 8, 'img/zapatillas3.jpg', 0, 0),
(20, 'buzo PALM ANGELS ', 'Buzo de algodón, color blanco, disponible en todos los talles', 23000.00, 0, 'img/buzo2.jpg', 0, 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol` enum('usuario','admin') DEFAULT 'usuario',
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `verificado` tinyint(1) DEFAULT 0,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultima_conexion` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `contraseña`, `email`, `rol`, `estado`, `verificado`, `creado_en`, `ultima_conexion`) VALUES
(1, 'Admin', 'admin123', 'admin@example.com', 'admin', 'activo', 0, '2024-12-14 05:39:02', NULL),
(2, 'Usuario', 'usuario123', 'usuario@example.com', 'usuario', 'activo', 0, '2024-12-14 05:39:02', NULL),
(5, 'hola', '1234', 'Franxd776@gmail.com', 'usuario', 'activo', 0, '2024-12-14 20:25:18', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
