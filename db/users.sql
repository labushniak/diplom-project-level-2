-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 03 2020 г., 12:27
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `level2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(255) NOT NULL DEFAULT 1,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `group_id`, `date`, `status`) VALUES
(1, 'test@test.ru', 'admin', '$2y$10$cx4in/9heoQzbDFOQcM9H.j1m5yuYngF3zpftPfGz0TaH0udh13cG', 2, '2020-12-01', 'Привет! Я новый пользователь вашего проекта, хочу перейти на уровень 3!'),
(2, 'test2@test.ru', 'Сергей', '$2y$10$DJy1/re8iBueTf5T7TzhI.GHbh9JWNtESYcMlo3FByXBr7.kHI80K', 2, '2020-12-01', 'Учусь!'),
(3, 'test3@test.ru', 'Александр', '$2y$10$NcW5Ba/8xFNu/D1uJ9AvreleM8dd.jGlj/ICocfGTy5Cf/kHZBv2q', 1, '2020-12-03', 'только зарегистрировался'),
(4, 'test4@test.ru', 'Петр', '$2y$10$pzpf7nKotZGWdtUtxQ2IgeO3G4inoScvAESsYrMdkzYNC6dBJQ/yG', 1, '2020-12-03', 'только зарегистрировался'),
(5, 'test5@test.ru', 'Остап', '$2y$10$0.6Xa4LHtni7.AeayHXE2e.Bnp5w0Z.Ukms0ufhYSjTwKR.uxaSye', 2, '2020-12-03', 'только зарегистрировался'),
(6, 'test6@test.ru', 'Вадим', '$2y$10$M3QZzaFXOIAibpoF.JPpr.e.jMDOy6eXpwoQtzu4HajnmmpP9g6u6', 1, '2020-12-03', 'только зарегистрировался'),
(7, 'test7@test.ru', 'Илья', '$2y$10$3vk7IurY3/K2Ex8CdIXgSe9kOYZGtdGwN41kBJgtNRyUCNzzi739e', 2, '2020-12-03', 'только зарегистрировался'),
(8, 'test8@test.ru', 'Родион', '$2y$10$Rnb6gyQ4IV60.Y0ZgzRfBuFgG9xnYSwLvJXW/MRzk74I0wiFL2pta', 1, '2020-12-03', 'только зарегистрировался'),
(9, 'test9@test.ru', 'Павел', '$2y$10$k3G0bKkAqhXjKiu4ULVGO.jUkHcy7CfsJF7OiId0y5HBmxj3hDsrS', 1, '2020-12-03', 'только зарегистрировался'),
(10, 'test10@test.ru', 'Владимир', '$2y$10$yhxuM3P8WLPmYRMWIWwi6uE6yAvj20IXvceB23jVco.Z/HDgGZZru', 1, '2020-12-03', 'только зарегистрировался');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
