-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2022 a las 04:30:58
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancolombia`
--

CREATE TABLE `bancolombia` (
  `id` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `tipoCuenta` varchar(50) NOT NULL,
  `numeroCuenta` varchar(50) NOT NULL,
  `ultimoMovimiento` datetime NOT NULL,
  `fechaRegistro` date NOT NULL,
  `codigoSeguridad` int(11) NOT NULL,
  `saldoDisponible` float NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bancolombia`
--

INSERT INTO `bancolombia` (`id`, `idPersona`, `tipoCuenta`, `numeroCuenta`, `ultimoMovimiento`, `fechaRegistro`, `codigoSeguridad`, `saldoDisponible`, `email`) VALUES
(1, 1, 'Ahorros', '123456789', '2022-11-09 07:45:15', '2021-05-13', 1234, 60500, 'rafa@gmail.com'),
(2, 1, 'Corriente', '987654321', '2020-05-19 07:45:15', '2022-09-21', 1212, 12000, 'everlides@gmail.com'),
(3, 2, 'Corriente', '192837465', '2022-09-25 10:05:00', '2022-09-25', 1111, 45670, 'saul@mail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id` int(11) NOT NULL,
  `identificacion` varchar(15) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id`, `identificacion`, `nombres`, `apellidos`) VALUES
(1, '1067840458', 'Rafael', ' Navarro'),
(2, '50892042', 'Everlides', 'Torreglosa'),
(4, '6890410', 'Saul', 'Navarro');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bancolombia`
--
ALTER TABLE `bancolombia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_persona` (`idPersona`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bancolombia`
--
ALTER TABLE `bancolombia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bancolombia`
--
ALTER TABLE `bancolombia`
  ADD CONSTRAINT `fk_estudiante` FOREIGN KEY (`idPersona`) REFERENCES `estudiante` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
