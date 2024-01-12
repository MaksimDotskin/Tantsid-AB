-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 12 2024 г., 12:26
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `d123173_tantsid`
--

-- --------------------------------------------------------

--
-- Структура таблицы `kasutaja`
--

CREATE TABLE `kasutaja` (
  `id` int(11) NOT NULL,
  `kasutaja` varchar(35) DEFAULT NULL,
  `parool` varchar(35) DEFAULT NULL,
  `onAdmin` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `kasutaja`
--

INSERT INTO `kasutaja` (`id`, `kasutaja`, `parool`, `onAdmin`) VALUES
(1, 'admin', 'suyMO8iwDz0vU', b'1'),
(2, 'opilane', 'su.WTbHPNsNIs', b'0');

-- --------------------------------------------------------

--
-- Структура таблицы `tantsid`
--

CREATE TABLE `tantsid` (
  `id` int(11) NOT NULL,
  `tantsupaar` varchar(30) DEFAULT NULL,
  `punktid` int(11) DEFAULT 0,
  `kommentaarid` text DEFAULT ' ',
  `ava_paev_` datetime DEFAULT NULL,
  `avalik` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tantsid`
--

INSERT INTO `tantsid` (`id`, `tantsupaar`, `punktid`, `kommentaarid`, `ava_paev_`, `avalik`) VALUES
(1, 'Max+Bogdan', 2, ' sadsadsafsdegt, gdfgdf, ', '2024-01-01 12:01:02', 1),
(2, 'Olga+Artur', 0, ' ', '2024-01-01 12:00:52', 1),
(9, 'Irina+Marina', 0, ' ', '2024-01-12 10:23:08', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `kasutaja`
--
ALTER TABLE `kasutaja`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tantsid`
--
ALTER TABLE `tantsid`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tantsupaar` (`tantsupaar`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `kasutaja`
--
ALTER TABLE `kasutaja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `tantsid`
--
ALTER TABLE `tantsid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
