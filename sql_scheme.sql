-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 08-08-2018 a las 23:26:09
-- Versión del servidor: 5.5.56-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `teoriza_virtualpol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foros`
--

CREATE TABLE `foros` (
  `ID` smallint(5) NOT NULL,
  `subforo_ID` smallint(6) UNSIGNED DEFAULT NULL,
  `url` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(50) NOT NULL DEFAULT '',
  `descripcion` varchar(255) NOT NULL DEFAULT '',
  `acceso` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `time` smallint(3) NOT NULL DEFAULT '1',
  `estado` enum('ok','eliminado') NOT NULL DEFAULT 'ok',
  `acceso_msg` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `acceso_leer` varchar(900) NOT NULL DEFAULT 'anonimos',
  `acceso_escribir` varchar(900) NOT NULL DEFAULT 'ciudadanos_global',
  `acceso_escribir_msg` varchar(255) DEFAULT 'ciudadanos_global',
  `acceso_cfg_leer` varchar(900) NOT NULL DEFAULT '',
  `acceso_cfg_escribir` varchar(900) NOT NULL DEFAULT '',
  `acceso_cfg_escribir_msg` varchar(900) NOT NULL DEFAULT '',
  `limite` tinyint(3) UNSIGNED NOT NULL DEFAULT '8'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foros_hilos`
--

CREATE TABLE `foros_hilos` (
  `ID` mediumint(8) NOT NULL,
  `sub_ID` smallint(5) NOT NULL DEFAULT '0',
  `url` varchar(80) NOT NULL DEFAULT '',
  `user_ID` mediumint(8) NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL DEFAULT '',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `cargo` tinyint(3) NOT NULL DEFAULT '0',
  `num` smallint(5) NOT NULL DEFAULT '0',
  `estado` enum('ok','borrado') NOT NULL DEFAULT 'ok',
  `votos` smallint(6) NOT NULL DEFAULT '0',
  `votos_num` mediumint(9) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foros_msg`
--

CREATE TABLE `foros_msg` (
  `ID` int(10) UNSIGNED NOT NULL,
  `hilo_ID` mediumint(8) NOT NULL DEFAULT '0',
  `user_ID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `cargo` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `estado` enum('ok','borrado') NOT NULL DEFAULT 'ok',
  `time2` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `votos` smallint(6) NOT NULL DEFAULT '0',
  `votos_num` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api`
--

CREATE TABLE `api` (
  `api_ID` int(11) UNSIGNED NOT NULL,
  `item_ID` varchar(255) DEFAULT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `tipo` enum('facebook','twitter') DEFAULT 'facebook',
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `nombre` varchar(255) DEFAULT NULL,
  `linea_editorial` text,
  `url` varchar(255) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `acceso_escribir` text,
  `acceso_borrador` text,
  `clave` text,
  `num` mediumint(9) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api_posts`
--

CREATE TABLE `api_posts` (
  `post_ID` int(11) UNSIGNED NOT NULL,
  `pais` varchar(255) DEFAULT NULL,
  `api_ID` mediumint(9) UNSIGNED DEFAULT NULL,
  `estado` enum('publicado','cron','borrado','pendiente') NOT NULL DEFAULT 'pendiente',
  `mensaje_ID` varchar(900) DEFAULT NULL,
  `pendiente_user_ID` mediumint(8) UNSIGNED DEFAULT NULL,
  `publicado_user_ID` mediumint(9) UNSIGNED DEFAULT NULL,
  `borrado_user_ID` mediumint(8) UNSIGNED DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_cron` datetime DEFAULT '0000-00-00 00:00:00',
  `message` text,
  `picture` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------



--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `ID` smallint(6) NOT NULL,
  `pais` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cargo_ID` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `asigna` smallint(5) NOT NULL DEFAULT '7',
  `nombre` varchar(32) NOT NULL DEFAULT '',
  `nombre_extra` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `nivel` tinyint(3) NOT NULL DEFAULT '1',
  `num` smallint(5) NOT NULL DEFAULT '0',
  `salario` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `autocargo` enum('true','false') CHARACTER SET utf8 NOT NULL DEFAULT 'false',
  `elecciones` datetime DEFAULT NULL,
  `elecciones_electos` tinyint(3) UNSIGNED DEFAULT NULL,
  `elecciones_cada` smallint(5) UNSIGNED DEFAULT NULL,
  `elecciones_durante` tinyint(3) UNSIGNED DEFAULT NULL,
  `elecciones_votan` varchar(999) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos_users`
--

CREATE TABLE `cargos_users` (
  `ID` bigint(20) NOT NULL,
  `cargo_ID` smallint(5) NOT NULL DEFAULT '0',
  `pais` varchar(30) DEFAULT NULL,
  `user_ID` mediumint(8) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cargo` enum('true','false') NOT NULL DEFAULT 'false',
  `aprobado` enum('ok','no') NOT NULL DEFAULT 'ok',
  `nota` decimal(3,1) UNSIGNED NOT NULL DEFAULT '0.0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat`
--

CREATE TABLE `cat` (
  `ID` smallint(6) UNSIGNED NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `url` varchar(80) NOT NULL DEFAULT '',
  `nombre` varchar(80) NOT NULL DEFAULT '',
  `num` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `nivel` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tipo` enum('empresas','docs','cargos') NOT NULL DEFAULT 'docs',
  `orden` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `publicar` tinyint(1) NOT NULL DEFAULT '0',
  `tipo_impositivo` decimal(2,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE `chats` (
  `chat_ID` smallint(5) UNSIGNED NOT NULL,
  `estado` enum('activo','bloqueado','en_proceso','expirado','borrado') NOT NULL DEFAULT 'en_proceso',
  `pais` varchar(30) DEFAULT NULL,
  `url` varchar(90) NOT NULL,
  `titulo` varchar(90) NOT NULL,
  `user_ID` mediumint(8) UNSIGNED NOT NULL,
  `admin` varchar(900) NOT NULL DEFAULT '',
  `acceso_leer` varchar(30) NOT NULL DEFAULT 'anonimos',
  `acceso_escribir` varchar(30) DEFAULT 'ciudadanos_global',
  `acceso_escribir_ex` varchar(30) NOT NULL DEFAULT 'ciudadanos_global',
  `acceso_cfg_leer` varchar(900) DEFAULT '',
  `acceso_cfg_escribir` varchar(900) DEFAULT '',
  `acceso_cfg_escribir_ex` varchar(900) NOT NULL DEFAULT '',
  `fecha_creacion` datetime NOT NULL,
  `fecha_last` datetime NOT NULL,
  `dias_expira` smallint(5) UNSIGNED DEFAULT NULL,
  `url_externa` varchar(500) DEFAULT NULL,
  `stats_visitas` int(12) UNSIGNED NOT NULL DEFAULT '0',
  `stats_msgs` int(12) UNSIGNED NOT NULL DEFAULT '0',
  `GMT` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats_msg`
--

CREATE TABLE `chats_msg` (
  `msg_ID` int(8) UNSIGNED NOT NULL,
  `chat_ID` smallint(5) UNSIGNED NOT NULL,
  `nick` varchar(32) NOT NULL,
  `msg` varchar(900) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cargo` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `user_ID` mediumint(6) UNSIGNED NOT NULL DEFAULT '0',
  `tipo` enum('m','p','e','c') NOT NULL DEFAULT 'm',
  `IP` bigint(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `ID` smallint(5) UNSIGNED NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `dato` varchar(100) NOT NULL DEFAULT '',
  `valor` text NOT NULL,
  `autoload` enum('si','no') NOT NULL DEFAULT 'si'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docs`
--

CREATE TABLE `docs` (
  `ID` smallint(5) NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `text` longtext CHARACTER SET utf8 NOT NULL,
  `text_backup` longtext CHARACTER SET utf8 NOT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado` enum('ok','del','borrador') CHARACTER SET utf8 NOT NULL DEFAULT 'ok',
  `cat_ID` smallint(5) NOT NULL DEFAULT '0',
  `acceso_leer` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT 'anonimos',
  `acceso_escribir` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT 'privado',
  `acceso_cfg_leer` varchar(800) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `acceso_cfg_escribir` varchar(800) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `version` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `pad_ID` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `ID` mediumint(9) UNSIGNED NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `user_ID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cargo_ID` smallint(5) NOT NULL DEFAULT '0',
  `nota` varchar(5) NOT NULL DEFAULT '5',
  `num_preguntas` smallint(5) UNSIGNED NOT NULL DEFAULT '1',
  `ID_old` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes_preg`
--

CREATE TABLE `examenes_preg` (
  `ID` int(11) UNSIGNED NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `examen_ID` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `user_ID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pregunta` text NOT NULL,
  `respuestas` text NOT NULL,
  `tiempo` varchar(6) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `grupo_ID` int(11) UNSIGNED NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `num` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hechos`
--

CREATE TABLE `hechos` (
  `ID` mediumint(8) UNSIGNED NOT NULL,
  `pais` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `time` date NOT NULL,
  `nick` varchar(14) CHARACTER SET utf8 NOT NULL,
  `texto` varchar(2000) CHARACTER SET utf8 NOT NULL,
  `estado` enum('ok','del') CHARACTER SET utf8 NOT NULL DEFAULT 'ok',
  `time2` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;




-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_ID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `nick` varchar(20) NOT NULL DEFAULT '',
  `accion` text NOT NULL,
  `accion_a` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `ID` int(10) UNSIGNED NOT NULL,
  `envia_ID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `recibe_ID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `text` text NOT NULL,
  `leido` enum('0','1') NOT NULL DEFAULT '0',
  `cargo` smallint(5) NOT NULL DEFAULT '0',
  `recibe_masivo` varchar(10) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `noti_ID` int(11) UNSIGNED NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `emisor` varchar(30) NOT NULL DEFAULT 'sistema',
  `visto` enum('true','false') NOT NULL DEFAULT 'false',
  `user_ID` mediumint(8) NOT NULL DEFAULT '0',
  `texto` varchar(60) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `referencias`
--

CREATE TABLE `referencias` (
  `ID` mediumint(8) NOT NULL,
  `user_ID` mediumint(8) NOT NULL DEFAULT '0',
  `IP` varchar(10) NOT NULL DEFAULT '',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `referer` varchar(255) NOT NULL DEFAULT '',
  `pagado` enum('0','1') NOT NULL DEFAULT '0',
  `new_user_ID` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resources`
--

CREATE TABLE `resources` (
  `ID` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `type` enum('currency','item','material','') NOT NULL,
  `icon` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stats`
--

CREATE TABLE `stats` (
  `stats_ID` smallint(5) UNSIGNED NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ciudadanos` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `nuevos` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `pols` int(10) NOT NULL DEFAULT '0',
  `pols_cuentas` int(10) NOT NULL DEFAULT '0',
  `transacciones` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `hilos_msg` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `pols_gobierno` int(10) NOT NULL DEFAULT '0',
  `partidos` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `frase` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `empresas` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `eliminados` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `mapa` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `mapa_vende` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `24h` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `confianza` smallint(5) DEFAULT '0',
  `autentificados` mediumint(9) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test`
--

CREATE TABLE `test` (
  `msg_id` int(10) UNSIGNED NOT NULL,
  `canal` decimal(10,0) UNSIGNED DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_publicacion` datetime DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `texto` varchar(900) DEFAULT NULL,
  `participante` varchar(900) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `participantes_num` decimal(10,0) UNSIGNED DEFAULT NULL,
  `puntos` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `ID` mediumint(8) UNSIGNED NOT NULL,
  `nick` varchar(18) NOT NULL DEFAULT '',
  `lang` varchar(5) DEFAULT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `estado` enum('turista','ciudadano','expulsado','validar') NOT NULL DEFAULT 'validar',
  `nivel` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `cargo` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `cargos` varchar(400) NOT NULL DEFAULT '',
  `grupos` varchar(400) NOT NULL DEFAULT '',
  `examenes` varchar(400) NOT NULL DEFAULT '',
  `voto_confianza` smallint(5) NOT NULL DEFAULT '0',
  `confianza_historico` text NOT NULL,
  `partido_afiliado` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `online` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `visitas` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `paginas` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `pols` decimal(10,2) NOT NULL DEFAULT '0.00',
  `email` varchar(255) NOT NULL DEFAULT '',
  `fecha_registro` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_init` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rechazo_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_legal` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nickchange_last` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pass` varchar(255) NOT NULL DEFAULT '',
  `pass2` varchar(255) NOT NULL DEFAULT '',
  `api_pass` varchar(16) NOT NULL DEFAULT '0',
  `api_num` smallint(5) NOT NULL DEFAULT '0',
  `num_elec` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `SC` enum('true','false') NOT NULL DEFAULT 'false',
  `ser_SC` enum('true','false','block') NOT NULL DEFAULT 'false',
  `nota` decimal(3,1) NOT NULL DEFAULT '0.0',
  `donacion` mediumint(9) UNSIGNED DEFAULT NULL,
  `avatar` enum('true','false') NOT NULL DEFAULT 'false',
  `IP` varchar(12) NOT NULL DEFAULT '0',
  `host` varchar(150) NOT NULL,
  `hosts` text,
  `IP_proxy` varchar(150) NOT NULL,
  `text` varchar(2300) NOT NULL DEFAULT '',
  `nav` varchar(500) NOT NULL,
  `avatar_localdir` varchar(100) NOT NULL,
  `x` decimal(10,2) DEFAULT NULL,
  `y` decimal(10,2) DEFAULT NULL,
  `socio` enum('true','false') NOT NULL DEFAULT 'false',
  `dnie` enum('true','false') DEFAULT 'false',
  `dnie_check` varchar(400) DEFAULT NULL,
  `ref` varchar(25) NOT NULL DEFAULT '',
  `ref_num` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `bando` varchar(255) DEFAULT NULL,
  `nota_SC` varchar(500) NOT NULL DEFAULT '',
  `traza` varchar(600) NOT NULL DEFAULT '',
  `datos` varchar(9999) NOT NULL DEFAULT '',
  `nombre` varchar(255) DEFAULT NULL,
  `temp` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_con`
--

CREATE TABLE `users_con` (
  `ID` int(11) UNSIGNED NOT NULL,
  `time` datetime DEFAULT NULL,
  `tipo` enum('session','login') DEFAULT 'login',
  `user_ID` mediumint(8) UNSIGNED DEFAULT NULL,
  `IP` int(11) UNSIGNED DEFAULT NULL,
  `IP_rango` varchar(255) DEFAULT NULL,
  `IP_rango3` varchar(20) DEFAULT NULL,
  `IP_pais` varchar(2) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `ISP` varchar(255) DEFAULT NULL,
  `proxy` varchar(255) DEFAULT NULL,
  `login_seg` smallint(5) UNSIGNED DEFAULT NULL,
  `login_ms` smallint(5) UNSIGNED DEFAULT NULL,
  `dispositivo` bigint(20) UNSIGNED DEFAULT NULL,
  `nav_resolucion` varchar(255) DEFAULT NULL,
  `nav` varchar(500) DEFAULT NULL,
  `nav_so` varchar(255) DEFAULT NULL,
  `referer` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_resources`
--

CREATE TABLE `user_resources` (
  `ID` int(11) NOT NULL,
  `user_id` mediumint(8) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion`
--

CREATE TABLE `votacion` (
  `ID` smallint(5) NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `estado` enum('ok','end','borrador') NOT NULL DEFAULT 'borrador',
  `pregunta` varchar(255) NOT NULL DEFAULT '',
  `descripcion` text NOT NULL,
  `respuestas` text NOT NULL,
  `num` smallint(5) NOT NULL DEFAULT '0',
  `num_censo` int(11) UNSIGNED DEFAULT NULL,
  `tipo` enum('sondeo','referendum','parlamento','destituir','otorgar','cargo','elecciones') NOT NULL DEFAULT 'sondeo',
  `tipo_voto` enum('estandar','3puntos','5puntos','8puntos','multiple','aleatorio') NOT NULL DEFAULT 'estandar',
  `privacidad` enum('true','false') NOT NULL DEFAULT 'true',
  `aleatorio` enum('true','false') NOT NULL DEFAULT 'false',
  `ejecutar` text NOT NULL,
  `duracion` mediumint(9) UNSIGNED NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `acceso_votar` varchar(30) NOT NULL DEFAULT 'ciudadanos_global',
  `acceso_cfg_votar` varchar(900) NOT NULL DEFAULT '',
  `acceso_ver` varchar(255) NOT NULL DEFAULT 'anonimos',
  `acceso_cfg_ver` varchar(900) NOT NULL DEFAULT '',
  `debate_url` varchar(255) NOT NULL DEFAULT '',
  `user_ID` mediumint(8) NOT NULL DEFAULT '0',
  `votos_expire` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `respuestas_desc` text NOT NULL,
  `cargo_ID` smallint(6) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion_argumentos`
--

CREATE TABLE `votacion_argumentos` (
  `ID` int(11) UNSIGNED NOT NULL,
  `ref_ID` mediumint(8) UNSIGNED DEFAULT NULL,
  `user_ID` mediumint(8) UNSIGNED DEFAULT NULL,
  `time` datetime DEFAULT '0000-00-00 00:00:00',
  `sentido` varchar(255) NOT NULL DEFAULT '',
  `texto` varchar(900) NOT NULL DEFAULT '',
  `votos` mediumint(8) DEFAULT '0',
  `votos_num` mediumint(9) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion_votos`
--

CREATE TABLE `votacion_votos` (
  `ID` int(11) UNSIGNED NOT NULL,
  `ref_ID` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `user_ID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `time` datetime DEFAULT NULL,
  `voto` varchar(300) NOT NULL DEFAULT '0',
  `validez` enum('true','false') NOT NULL DEFAULT 'true',
  `autentificado` enum('true','false') DEFAULT 'false',
  `mensaje` varchar(500) NOT NULL DEFAULT '',
  `comprobante` varchar(600) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `voto_ID` int(11) UNSIGNED NOT NULL,
  `pais` varchar(30) DEFAULT NULL,
  `item_ID` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `emisor_ID` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `receptor_ID` mediumint(9) UNSIGNED DEFAULT NULL,
  `voto` tinyint(3) NOT NULL,
  `tipo` enum('confianza','hilos','msg','argumentos') NOT NULL DEFAULT 'confianza',
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

