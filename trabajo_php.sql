-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-02-2024 a las 23:44:25
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `trabajo_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_cost` decimal(6,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `user_id`, `order_date`) VALUES
(3, 99.00, 2, '2024-02-01 21:53:57'),
(4, 99.00, 2, '2024-02-01 23:03:03'),
(5, 0.00, 2, '2024-02-02 01:57:34'),
(6, 59.00, 2, '2024-02-02 02:03:07'),
(7, 295.00, 2, '2024-02-02 02:14:58'),
(8, 236.00, 2, '2024-02-02 02:30:17'),
(9, 99.99, 1, '2024-02-02 22:23:55'),
(10, 420.00, 1, '2024-02-02 23:28:09'),
(11, 525.00, 1, '2024-02-02 23:35:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_image2` varchar(255) DEFAULT NULL,
  `product_image3` varchar(255) DEFAULT NULL,
  `product_image4` varchar(255) DEFAULT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `product_special_offer` int(2) DEFAULT NULL,
  `product_color` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_category`, `product_description`, `product_image`, `product_image2`, `product_image3`, `product_image4`, `product_price`, `product_special_offer`, `product_color`) VALUES
(1, 'Zapatillas de Correr', 'Zapatos', 'Zapatos to fast to furious', 'destacado1.jpg', 'destacado1.jpg', 'destacado1.jpg', 'destacado1.jpg', 105.00, 0, 'blanco'),
(2, 'Mochila Deportiva', 'Mochila', 'Mochila to flamas', 'destacado2.jpg', 'destacado2.jpg', 'destacado2.jpg', 'destacado2.jpg', 59.00, 0, 'amarillo'),
(3, 'Sudadera Básica', 'Sudadera', 'Sudadera aburrida', 'destacado3.jpg', 'destacado3.jpg', 'destacado3.jpg', 'destacado3.jpg', 69.00, 0, 'negro'),
(4, 'Guantes de Boxeo', 'Guantes', 'Guantes de Rocky', 'destacado4.jpg', 'destacado4.jpg', 'destacado4.jpg', 'destacado4.jpg', 69.00, 0, 'rojo'),
(8, 'Calcetines fucsia', 'Calcetines', 'Calcetines llamativos', 'destacado5.jpg', 'destacado5.jpg', 'destacado5.jpg', 'destacado5.jpg', 19.99, 0, 'Fucsia'),
(9, 'Zapatillas Gris', 'Zapatillas', 'Zapatillas de andar en la calle', 'destacado6.jpg', 'destacado6.jpg', 'destacado6.jpg', 'destacado6.jpg', 29.99, 0, 'Gris'),
(10, 'Conjunto', 'Conjunto', 'Conjunto verde llamativo', 'destacado7.jpg', 'destacado7.jpg', 'destacado7.jpg', 'destacado7.jpg', 39.99, 0, 'Verde'),
(11, 'Sudadera', 'Sudadera', 'Sudadera Balenciaga', 'destacado8.jpg', 'destacado8.jpg', 'destacado8.jpg', 'destacado8.jpg', 339.99, 0, 'Verde'),
(12, 'Top Deportivo', 'Top', 'Top deportivo cómodo', 'destacado9.jpg', 'destacado9.jpg', 'destacado9.jpg', 'destacado9.jpg', 39.99, 0, 'Negro'),
(13, 'Chaqueta', 'Chaqueta', 'Chaqueta gris formal', 'destacado10.jpg', 'destacado10.jpg', 'destacado10.jpg', 'destacado10.jpg', 139.99, 0, 'Gris'),
(14, 'Zapatillas Deporte', 'Zapatos', 'Zapatillas deporte rápidas', 'destacado11.jpg', 'destacado11.jpg', 'destacado11.jpg', 'destacado11.jpg', 99.99, 0, 'Blanco'),
(15, 'Zapatillas Azules', 'Zapatos', 'Zapatos deporte ligeros', 'destacado12.jpg', 'destacado12.jpg', 'destacado12.jpg', 'destacado12.jpg', 139.99, 0, 'Azul'),
(16, 'asdfa', 'asdf', 'asdf', '', NULL, NULL, NULL, 2.00, NULL, 'asdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `role`) VALUES
(1, 'usuario', 'usuario1@mail.com', 'usuario', 'user'),
(2, 'admin', 'admin@mail.com', 'admin', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UX_Constraint` (`user_email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
