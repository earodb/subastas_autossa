-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-11-2020 a las 06:02:04
-- Versión del servidor: 8.0.21
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `subastas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auto`
--

DROP TABLE IF EXISTS `auto`;
CREATE TABLE IF NOT EXISTS `auto` (
  `id_auto` int NOT NULL AUTO_INCREMENT,
  `marca` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `linea` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `modelo` int NOT NULL,
  `num_motor` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `num_chasis` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `num_cilindros` int NOT NULL,
  `cc` int NOT NULL,
  `tipo_transmision` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `estado` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagenes` json NOT NULL,
  `id_categoria` int DEFAULT NULL,
  PRIMARY KEY (`id_auto`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `auto`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `categoria`) VALUES
(1, 'Microcoche'),
(2, 'Segmento A'),
(3, 'Segmento B'),
(4, 'Segmento C'),
(5, 'Segmento D'),
(6, 'Segmento E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesta`
--

DROP TABLE IF EXISTS `cesta`;
CREATE TABLE IF NOT EXISTS `cesta` (
  `id_cesta` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_subasta` int NOT NULL,
  PRIMARY KEY (`id_cesta`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cesta`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

DROP TABLE IF EXISTS `oferta`;
CREATE TABLE IF NOT EXISTS `oferta` (
  `id_oferta` int NOT NULL AUTO_INCREMENT,
  `oferta` int NOT NULL,
  `estado` int NOT NULL,
  `fecha` datetime NOT NULL,
  `id_subasta` int NOT NULL,
  `comprador` int NOT NULL,
  PRIMARY KEY (`id_oferta`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `oferta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subasta`
--

DROP TABLE IF EXISTS `subasta`;
CREATE TABLE IF NOT EXISTS `subasta` (
  `id_subasta` int NOT NULL AUTO_INCREMENT,
  `min` int DEFAULT NULL,
  `max` int DEFAULT NULL,
  `tiempo_ini` datetime NOT NULL,
  `tiempo_fin` datetime NOT NULL,
  `estado` int NOT NULL,
  `comprador` int DEFAULT NULL,
  `subastador` int NOT NULL,
  `id_auto` int NOT NULL,
  PRIMARY KEY (`id_subasta`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `subasta`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id_tipouser` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_tipouser`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipouser`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `apellido` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `edad` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `foto` varchar(300) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `user` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_tipouser` int NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `edad`, `foto`, `correo`, `user`, `pass`, `id_tipouser`) VALUES
(1, 'Eduardo', 'Rodríguez', '29', '', 'earodb@gmail.com', 'earodb', 'earb0113', 1),
(2, 'Amanda', 'Rodríguez', '30', '', 'amanda@gmail.com', 'amanda', 'amanda', 2),
(3, 'Jakeline', 'González', '70', '', 'jakeline@gmail.com', 'jakeline', 'jakeline', 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
