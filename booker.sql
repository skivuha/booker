-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 28 2015 г., 00:29
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=383 ;

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
  `status` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_employee`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `employee`
--

INSERT INTO `employee` (`id_employee`, `name_employee`, `passwd_employee`, `key_employee`, `code_employee`, `mail_employee`, `role`, `status`) VALUES
(1, 'first', 'f36f5f8c2039e9a5dfd6f9671fe4aa69', '6b32im00b5', '7f1b9816ia', 'first@f.com', '0', '1'),
(2, 'test', '43ca63420815d4de754e9ef1a4eaafdf', 'm9a4777033', '', '', '0', '0'),
(3, 'root', '811c608de5dfab3c424d570e42114e87', 'aa48e5iima', 'b5074ib4m1', 'root@root.com', '1', '1'),
(4, 'JJAbrams', '3554d7d2a8bf0bffa5e39ab10596ef92', '3bcm3c3i42', '', 'abrems@i.com', '0', '1'),
(5, 'newUser', '68fe98853a31f57bec1b4cafcc26a1d2', '44e14ae540', '', 'lala2@yahoo.com', '0', '1'),
(6, 'test', '9eb8ce7f352dcc7965647fa0f03c50f7', '28i292f90m', '', 'test@test.com', '0', '1'),
(7, 'dimas', '649c9ccd33c77e14afa1e322d2b31603', '2ffd33f3bi', '', '', '0', '0'),
(8, 'dima', '92a40044acf1fa7c4aba693d07a9dfda', '352id3bci1', '', '', '0', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id_room` int(11) NOT NULL AUTO_INCREMENT,
  `name_room` varchar(255) NOT NULL,
  PRIMARY KEY (`id_room`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `rooms`
--

INSERT INTO `rooms` (`id_room`, `name_room`) VALUES
(1, 'Boardroom #1'),
(2, 'Boardroom #2'),
(3, 'Boardroom #3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
