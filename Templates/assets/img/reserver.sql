-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-01-2019 a las 02:04:51
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reserver`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserver`
--

DROP TABLE IF EXISTS `reserver`;
CREATE TABLE IF NOT EXISTS `reserver` (
  `idReserver` int(11) NOT NULL AUTO_INCREMENT,
  `dateReserver` date NOT NULL,
  `timeReserver` time NOT NULL,
  `dateRequest` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nameCustomer` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `phoneCustomer` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `emailCustomer` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `numPerson` tinyint(2) NOT NULL,
  `typeReserver` tinyint(1) NOT NULL DEFAULT '1',
  `description` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `venues` tinyint(1) NOT NULL,
  PRIMARY KEY (`idReserver`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `reserver`
--

INSERT INTO `reserver` (`idReserver`, `dateReserver`, `timeReserver`, `dateRequest`, `nameCustomer`, `phoneCustomer`, `emailCustomer`, `numPerson`, `typeReserver`, `description`, `venues`) VALUES
(1, '2019-01-20', '20:00:00', '2019-01-19 08:35:46', 'Andres Sandoval', '3117772633', NULL, 2, 2, '', 3),
(11, '2019-01-23', '10:00:00', '2019-01-19 19:15:46', 'Carmen Vanessa', '3128095698', 'vanessa_23@gmail.com', 6, 2, 'Cumpleaños', 3),
(21, '2019-01-22', '15:00:00', '2019-01-20 12:48:22', 'Karol Rodriguez', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1),
(22, '2019-01-25', '14:30:00', '2019-01-21 10:07:22', 'Carlos Martinez', '3207049245', 'carlos.r@gmail.com', 6, 2, 'Aniversario', 2),
(27, '2019-01-21', '10:00:00', '2019-01-21 19:53:00', 'Javier Martines', '3207049245', 'javier.m@gmail.com', 5, 1, '', 1),
(28, '2019-01-21', '10:00:00', '2019-01-21 20:28:46', 'Javier Martines', '3207049245', 'javier.m@gmail.com', 5, 1, '', 1),
(29, '2019-01-21', '10:00:00', '2019-01-21 20:29:47', 'Javier Martines', '3207049245', 'javier.m@gmail.com', 5, 1, '', 1),
(30, '2019-01-21', '15:45:00', '2019-01-21 20:31:59', 'Gustavo Torres', '3117772655', 'g.torres@gmail.com', 3, 1, '', 1),
(31, '2019-01-21', '15:45:00', '2019-01-21 20:34:20', 'Gustavo Torres', '3117772655', 'g.torres@gmail.com', 3, 1, '', 1),
(32, '2019-01-21', '15:45:00', '2019-01-21 20:34:45', 'Gustavo Torres', '3117772655', 'g.torres@gmail.com', 3, 1, '', 1),
(33, '2019-01-21', '15:45:00', '2019-01-21 20:44:16', 'Gustavo Torres', '3117772655', 'sandovalfenix@gmail.com', 3, 1, '', 1),
(34, '2019-01-21', '15:00:00', '2019-01-21 20:52:10', 'Andres Sandoval', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1),
(35, '2019-01-21', '15:00:00', '2019-01-21 20:52:22', 'Andres Sandoval', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1),
(36, '2019-01-21', '15:00:00', '2019-01-21 20:54:25', 'Andres Sandoval', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1),
(37, '2019-01-21', '15:00:00', '2019-01-21 20:57:25', 'Andres Sandoval', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1),
(38, '2019-01-21', '15:00:00', '2019-01-21 20:58:39', 'Andres Sandoval', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1),
(39, '2019-01-21', '15:00:00', '2019-01-21 21:02:40', 'Andres Sandoval', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1),
(40, '2019-01-21', '15:00:00', '2019-01-21 21:02:51', 'Andres Sandoval', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1),
(41, '2019-01-21', '15:00:00', '2019-01-21 21:03:15', 'Andres Sandoval', '3117772633', 'sandovalfenix@gmail.com', 5, 1, '', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
