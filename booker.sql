-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 27 2015 г., 00:41
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=322 ;

--
-- Дамп данных таблицы `appointments`
--

INSERT INTO `appointments` (`id_appointment`, `description`, `id_employee`, `start`, `end`, `id_room`, `recursion`, `submitted`) VALUES
(190, '', 2, '1429750800', '1429765200', 1, 0, '2015-04-26 11:22:49'),
(191, '', 1, '1429664400', '1429671600', 1, 191, '2015-04-21 21:34:51'),
(196, '', 1, '1429653600', '1429655400', 1, 0, '2015-04-21 21:18:34'),
(211, '', 1, '1429689600', '1429693200', 2, 211, '2015-04-22 06:10:18'),
(215, '', 4, '1429689600', '1429693200', 1, 215, '2015-04-22 07:01:58'),
(218, '', 1, '1429700400', '1429704000', 2, 218, '2015-04-22 06:11:23'),
(227, '', 1, '1429736400', '1429738200', 3, 227, '2015-04-22 06:53:11'),
(240, '', 1, '1429822800', '1429824600', 1, 0, '2015-04-23 19:53:07'),
(254, '', 1, '1429840800', '1429866000', 3, 0, '2015-04-23 21:48:17'),
(255, '', 1, '1429869600', '1429873200', 3, 255, '2015-04-23 21:48:43'),
(273, '', 5, '1430168400', '1430177400', 1, 0, '2015-04-26 11:57:34'),
(285, '', 1, '1430341200', '1430353800', 1, 285, '2015-04-26 12:10:13'),
(286, '', 1, '1430946000', '1430951400', 1, 285, '2015-04-26 12:43:43'),
(287, '', 1, '1431550800', '1431563400', 1, 285, '2015-04-26 12:46:28'),
(288, '', 1, '1432155600', '1432164600', 1, 285, '2015-04-26 12:46:21'),
(289, '', 1, '1432760400', '1432769400', 1, 285, '2015-04-26 12:46:21'),
(290, '', 1, '1432166400', '1432170000', 1, 0, '2015-04-26 12:07:09'),
(295, '', 1, '1430958600', '1430967600', 1, 295, '2015-04-26 17:17:00'),
(296, '', 1, '1431563400', '1431572400', 1, 295, '2015-04-26 17:17:00'),
(297, '', 1, '1432168200', '1432177200', 1, 295, '2015-04-26 17:17:00'),
(306, '', 1, '1431302400', '1431306000', 1, 0, '2015-04-26 17:43:54'),
(317, '', 1, '1430701200', '1430703000', 1, 317, '2015-04-26 18:06:19'),
(318, '', 1, '1431306000', '1431307800', 1, 317, '2015-04-26 18:06:19'),
(319, '', 1, '1431910800', '1431912600', 1, 317, '2015-04-26 18:06:19'),
(320, '', 1, '1432515600', '1432517400', 1, 317, '2015-04-26 18:06:19'),
(321, '', 1, '1433120400', '1433122200', 1, 317, '2015-04-26 18:06:19');

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
(3, 'root', '8fff62860c81f63c43422def2aa40ced', '6853ieaf81', 'b5074ib4m1', 'root@root.com', '1', '1'),
(4, 'JJAbrams', '3554d7d2a8bf0bffa5e39ab10596ef92', '3bcm3c3i42', '', 'abrems@i.com', '0', '1'),
(5, 'newUser', '68fe98853a31f57bec1b4cafcc26a1d2', '44e14ae540', '', 'lala2@yahoo.com', '0', '1'),
(6, 'newtest', '32a4a472eda512007bc2bb1f3c1315f4', '0802id06i8', '', 'newnew@new.com', '0', '1'),
(7, 'dimas', '649c9ccd33c77e14afa1e322d2b31603', '2ffd33f3bi', '', '', '0', '0'),
(8, 'dima', '92a40044acf1fa7c4aba693d07a9dfda', '352id3bci1', '', 'd.shuliakov@gmail.com', '0', '1');

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
