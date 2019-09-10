-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 10 2019 г., 10:29
-- Версия сервера: 5.7.20-log
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `phalconttdb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `region` varchar(100) NOT NULL,
  `street` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `addresses`
--

INSERT INTO `addresses` (`id`, `city`, `postcode`, `region`, `street`, `user_id`) VALUES
(1, 'city1-1', '38748', 'region1-1', 'street1-1', 1),
(2, 'city1-2', '59867', 'region1-2', 'street1-2', 1),
(3, 'city2-1', '93088', 'region2-1', 'street2-1', 2),
(4, 'city2-2', '59253', 'region2-2', 'street2-2', 2),
(5, 'city2-3', '17948', 'region2-3', 'street2-3', 2),
(6, 'city2-4', '75876', 'region2-4', 'street2-4', 2),
(7, 'city3-1', '49574', 'region3-1', 'street3-1', 3),
(8, 'city3-2', '84418', 'region3-2', 'street3-2', 3),
(9, 'city4-1', '70225', 'region4-1', 'street4-1', 4),
(10, 'city4-2', '15353', 'region4-2', 'street4-2', 4),
(11, 'city4-3', '80835', 'region4-3', 'street4-3', 4),
(12, 'city5-1', '67604', 'region5-1', 'street5-1', 5),
(13, 'city5-2', '16504', 'region5-2', 'street5-2', 5),
(14, 'city5-3', '71703', 'region5-3', 'street5-3', 5),
(15, 'city6-1', '91046', 'region6-1', 'street6-1', 6),
(16, 'city6-2', '65397', 'region6-2', 'street6-2', 6),
(17, 'city6-3', '14234', 'region6-3', 'street6-3', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `types`
--

INSERT INTO `types` (`id`, `type`) VALUES
(1, 'admin'),
(2, 'client');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type_id`) VALUES
(1, 'user1-fst_name', 'luser1-lst_name', 'user1@example.com', '$2y$08$VFg4ZFJwZkVoOHBsd0Jqb.IWqex5kxUh5miRp7KNos39Y9s1i3vSO', 1),
(2, 'user2-fst_name', 'luser2-lst_name', 'user2@example.com', '$2y$08$akVrNTVLNWpnMi9EMTU4Su6QRApYmv990tvyAWWUMBMe8A1bHGL1O', 1),
(3, 'user3-fst_name', 'luser3-lst_name', 'user3@example.com', '$2y$08$Wjd1b0tHTlpETUZud3VnNeKgjTPJdy861aaY8EP9JH67QKr.Lb6Ca', 1),
(4, 'user4-fst_name', 'luser4-lst_name', 'user4@example.com', '$2y$08$L3RPRm1nVFpTaVVxUXYzKuGzjEEw.WfyWlpsoZu/1TZB9TU3JFDBa', 2),
(5, 'user5-fst_name', 'luser5-lst_name', 'user5@example.com', '$2y$08$dGZwcjB0WXdIVjFsUElUbOFE01Efrp7t7OBtpn8WaM2MVQdahZUES', 2),
(6, 'user6-fst_name', 'luser6-lst_name', 'user6@example.com', '$2y$08$M0o1SGFTNVAwRXFBanU3bO035zzj1HU2xxDexcXS.jmw8Q47rtF/y', 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_uindex` (`email`),
  ADD KEY `type_id` (`type_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
