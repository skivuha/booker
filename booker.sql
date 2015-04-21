-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 21 2015 г., 10:30
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `booker`
--

-- --------------------------------------------------------

--
-- Структура таблицы `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `id_appointment` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `id_employee` int(11) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  `id_room` int(11) NOT NULL,
  `recursion` int(11) NOT NULL,
  `submitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_appointment`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=163 ;

--
-- Дамп данных таблицы `appointments`
--

INSERT INTO `appointments` (`id_appointment`, `description`, `id_employee`, `start`, `end`, `id_room`, `recursion`, `submitted`) VALUES
(89, '', 3, '1458003600', '1458010800', 1, 0, '2015-04-20 18:14:21'),
(96, '', 3, '1459371600', '1459373400', 1, 96, '2015-04-20 18:18:31'),
(97, '', 3, '1462050000', '1462051800', 1, 96, '2015-04-20 18:18:31'),
(98, '', 3, '1459375200', '1459377000', 1, 98, '2015-04-20 18:19:30'),
(99, '', 3, '1462140000', '1462141800', 1, 98, '2015-04-20 18:19:30'),
(131, 'lalala', 3, '1429565400', '1429567200', 1, 131, '2015-04-20 21:34:39'),
(143, '', 3, '1429570800', '1429585200', 1, 0, '2015-04-20 22:02:39'),
(144, 'New event', 3, '1429588800', '1429592400', 1, 0, '2015-04-20 23:16:35'),
(145, '', 3, '1429610400', '1429612200', 1, 0, '2015-04-21 05:41:16'),
(161, '', 3, '1429657200', '1429664400', 1, 0, '2015-04-21 07:28:54'),
(162, '', 3, '1429668000', '1429675200', 1, 0, '2015-04-21 07:16:07');

-- --------------------------------------------------------

--
-- Структура таблицы `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id_employee` int(10) NOT NULL AUTO_INCREMENT,
  `name_employee` varchar(60) NOT NULL,
  `passwd_employee` varchar(255) NOT NULL,
  `key_employee` varchar(10) NOT NULL,
  `code_employee` varchar(10) NOT NULL,
  `mail_employee` varchar(255) NOT NULL,
  `role` enum('0','1') NOT NULL,
  PRIMARY KEY (`id_employee`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `employee`
--

INSERT INTO `employee` (`id_employee`, `name_employee`, `passwd_employee`, `key_employee`, `code_employee`, `mail_employee`, `role`) VALUES
(1, 'igor', 'adcb9bd51f5596d1f0f71e816356b386', '1111111111', '7f1b9816ia', 'igor@hotmail.com', '0'),
(2, 'test', '40b599578ad05afc27ceaac3dcaa83d2', 'eee9648d38', '', 'test@test.com', '0'),
(3, 'root', '8fff62860c81f63c43422def2aa40ced', '6853ieaf81', '47459f886m', 'root@root.com', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id_room` int(11) NOT NULL AUTO_INCREMENT,
  `name_room` varchar(255) NOT NULL,
  PRIMARY KEY (`id_room`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
