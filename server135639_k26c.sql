-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mariadb106.server135639.nazwa.pl:3306
-- Czas generowania: 15 Cze 2022, 23:46
-- Wersja serwera: 10.6.7-MariaDB-log
-- Wersja PHP: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `server135639_k26c`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id`, `restaurant_id`, `user_id`, `guest_id`, `message`, `is_approved`, `created_at`) VALUES
(8, 8, 1, '363baea9cba210afac6d7a556fca596e30c46333', 'k;ugilygyih', 1, '2022-06-15 14:49:25'),
(11, 9, NULL, '363baea9cba210afac6d7a556fca596e30c46333', 'piza\r\n', 1, '2022-06-15 19:54:20'),
(18, 5, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 'Dobre Kopytka', 1, '2022-06-15 21:04:39'),
(19, 1, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 'Super kawa, fajny barista', 1, '2022-06-15 21:05:22'),
(20, 11, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 'Były git naleśniki, super miejscówka', 1, '2022-06-15 21:05:50'),
(21, 9, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 'super zrobiłem swoją B)', 1, '2022-06-15 21:06:08'),
(22, 4, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 'Bariści fajni, i kawa też fajna', 1, '2022-06-15 21:06:20'),
(23, 8, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 'słabe, kawa średnia, ciasta odmrożone', 1, '2022-06-15 21:06:54'),
(25, 3, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 'super opcje dla vegan, mm humus', 1, '2022-06-15 21:07:28'),
(27, 6, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 'tanio i fajnie', 1, '2022-06-15 21:07:37'),
(28, 11, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'fajno zjeść', 1, '2022-06-15 21:07:51'),
(29, 2, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'chyba dobre', 1, '2022-06-15 21:08:05'),
(30, 5, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'zjadłbym', 1, '2022-06-15 21:08:16'),
(31, 1, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'najlepsza kawa', 1, '2022-06-15 21:08:37'),
(32, 9, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'mniam', 1, '2022-06-15 21:08:48'),
(34, 4, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'dobre ekspreso', 1, '2022-06-15 21:09:20'),
(35, 8, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'takie o', 1, '2022-06-15 21:09:30'),
(36, 3, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'nie lubie warzyw', 1, '2022-06-15 21:09:44'),
(37, 6, 5, '2566eb407515829207886336069fb6ef3d10c02a', 'supi', 1, '2022-06-15 21:09:53'),
(38, 2, NULL, '9498fc58b018cfc624806bb2d799f678ce921214', 'fajna kawa\r\n', 0, '2022-06-15 21:17:10'),
(39, 1, NULL, '9498fc58b018cfc624806bb2d799f678ce921214', 'nie byłem', 0, '2022-06-15 21:17:19'),
(40, 8, NULL, '9498fc58b018cfc624806bb2d799f678ce921214', 'nic specjalnego', 0, '2022-06-15 21:17:34');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Zrzut danych tabeli `rating`
--

INSERT INTO `rating` (`id`, `restaurant_id`, `user_id`, `guest_id`, `rating`, `created_at`) VALUES
(8, 1, NULL, '363baea9cba210afac6d7a556fca596e30c46333', 5, '2022-06-15 14:03:28'),
(9, 8, NULL, '363baea9cba210afac6d7a556fca596e30c46333', 1, '2022-06-15 14:04:14'),
(10, 5, 2, '0c9c2f7d555b2fd3c7019fb711fca85db6f85a3a', 5, '2022-06-15 20:38:29'),
(11, 5, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 5, '2022-06-15 20:50:52'),
(12, 6, 2, '0c9c2f7d555b2fd3c7019fb711fca85db6f85a3a', 5, '2022-06-15 21:02:09'),
(13, 2, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 4, '2022-06-15 21:02:49'),
(14, 1, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 5, '2022-06-15 21:02:53'),
(15, 9, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 5, '2022-06-15 21:02:58'),
(16, 4, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 5, '2022-06-15 21:03:03'),
(17, 8, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 1, '2022-06-15 21:03:07'),
(18, 3, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 4, '2022-06-15 21:03:11'),
(19, 6, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 5, '2022-06-15 21:03:15'),
(20, 11, 4, '9498fc58b018cfc624806bb2d799f678ce921214', 4, '2022-06-15 21:05:38'),
(21, 5, 5, '2566eb407515829207886336069fb6ef3d10c02a', 4, '2022-06-15 21:07:13'),
(22, 2, 5, '2566eb407515829207886336069fb6ef3d10c02a', 4, '2022-06-15 21:07:26'),
(23, 11, 5, '2566eb407515829207886336069fb6ef3d10c02a', 4, '2022-06-15 21:07:44'),
(24, 1, 5, '2566eb407515829207886336069fb6ef3d10c02a', 5, '2022-06-15 21:08:39'),
(25, 9, 5, '2566eb407515829207886336069fb6ef3d10c02a', 5, '2022-06-15 21:08:50'),
(26, 4, 5, '2566eb407515829207886336069fb6ef3d10c02a', 4, '2022-06-15 21:09:05'),
(27, 8, 5, '2566eb407515829207886336069fb6ef3d10c02a', 2, '2022-06-15 21:09:26'),
(28, 3, 5, '2566eb407515829207886336069fb6ef3d10c02a', 3, '2022-06-15 21:09:38'),
(29, 6, 5, '2566eb407515829207886336069fb6ef3d10c02a', 5, '2022-06-15 21:09:50'),
(30, 8, 2, '0c9c2f7d555b2fd3c7019fb711fca85db6f85a3a', 1, '2022-06-15 21:13:54');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `guest_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Zrzut danych tabeli `reports`
--

INSERT INTO `reports` (`id`, `comment_id`, `guest_id`, `created_at`) VALUES
(1, 7, '363baea9cba210afac6d7a556fca596e30c46333', '2022-06-15 18:45:45'),
(2, 6, '363baea9cba210afac6d7a556fca596e30c46333', '2022-06-15 18:49:30'),
(4, 2, '363baea9cba210afac6d7a556fca596e30c46333', '2022-06-15 19:48:06'),
(5, 14, '9498fc58b018cfc624806bb2d799f678ce921214', '2022-06-15 20:50:59'),
(6, 14, '0c9c2f7d555b2fd3c7019fb711fca85db6f85a3a', '2022-06-15 20:51:11'),
(8, 17, '9498fc58b018cfc624806bb2d799f678ce921214', '2022-06-15 21:04:32'),
(9, 10, '9498fc58b018cfc624806bb2d799f678ce921214', '2022-06-15 21:05:24'),
(10, 4, '9498fc58b018cfc624806bb2d799f678ce921214', '2022-06-15 21:05:26'),
(11, 1, '9498fc58b018cfc624806bb2d799f678ce921214', '2022-06-15 21:05:29'),
(12, 3, '9498fc58b018cfc624806bb2d799f678ce921214', '2022-06-15 21:05:31'),
(14, 29, '0c9c2f7d555b2fd3c7019fb711fca85db6f85a3a', '2022-06-15 21:15:01');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 NOT NULL,
  `location` varchar(255) CHARACTER SET utf8mb3 NOT NULL,
  `rating` double NOT NULL DEFAULT 0,
  `votes` int(11) NOT NULL DEFAULT 0,
  `logo_url` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `keywords` text CHARACTER SET utf8mb3 DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Zrzut danych tabeli `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `location`, `rating`, `votes`, `logo_url`, `is_approved`, `keywords`, `created_at`) VALUES
(1, 'Miel', 'Poznań', 5, 3, 'https://static.wixstatic.com/media/78527a_6b02587589e846d39f300aa0b4cdf316~mv2.png', 1, 'miel, poznań, kawiarnia', '2022-06-10 23:10:21'),
(2, 'Guest coffeeCulture', 'Poznań', 4, 2, 'https://i.imgur.com/y0zDOBs.png', 1, 'guest coffee culture, poznań, kawiarnia', '2022-06-10 23:11:02'),
(3, 'Warzywniak', 'Poznań', 3.5, 2, 'https://www.restauracje-jedzenie-online.pl/img/logo_tcom/warzywniak-poznan-poznan.png', 1, 'warzywniak, poznań, vege, warzywa, owoce, sklep', '2022-06-10 23:11:47'),
(4, 'Plottwist espressobar', 'Poznań', 4.5, 2, 'https://i.imgur.com/sZOXy6k.png', 1, 'plottwist espressobar, poznań, kawiarnia, espresso, bar, ekspresso', '2022-06-10 23:12:27'),
(5, '4 alternatywy', 'Poznań', 4.6667, 3, 'https://static.oferteo.pl/images/portfolio/4061470/orig/73201_4alternatywy_logo-02.jpg', 1, 'kopytka', '2022-06-10 23:56:24'),
(6, 'Zahir Kebab', 'Poznań, Półwiejska 24', 5, 3, 'http://zahirkebab.pl/wp-content/uploads/2020/03/Kebab-Box.jpg', 1, 'Zahir Kebab, poznań półwiejska 24, kebab, tanio, sos', '2022-06-14 16:35:34'),
(8, 'starbucks', 'Poznań, Półwiejska 15', 1.25, 4, 'https://wszystkiesymbole.pl/wp-content/uploads/2021/04/Starbucks-logo.png', 1, 'starbucks, półwiejska 15, lipa, kawa, słaba, niepijalna, cukier, słodycze, niepijalne, brakszacunku', '2022-06-14 17:01:17'),
(9, 'Pizzatopia', 'Poznań, Wrocławska 30', 5, 2, 'https://static.pyszne.pl/images/restaurants/pl/07335711/logo_465x320.png', 1, 'pizzatopia, Poznań wrocławska 30, pizza, własna, smacznie, piwko', '2022-06-14 17:05:08'),
(10, 'McDonalds', 'Poznań, Półwiejska 16', 0, 0, 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/McDonald%27s_Golden_Arches.svg/1200px-McDonald%27s_Golden_Arches.svg.png', 0, 'McDonalds, Półwiejska 16, maczek, hamburger, fastfood, jedzenie, frytki, mata', '2022-06-15 21:04:24'),
(11, 'Manekin', 'Poznań, Kwiatowa 3, 60-995', 4, 2, 'https://yt3.ggpht.com/ytc/AKedOLSK4ICL7F5TgJ3aXbPnn1U1mUtF7OMTFiRzwkOZ=s900-c-k-c0x00ffffff-no-rj', 1, 'Manekin, Poznań, Kwiatowa 3, 60-995, naleśniki, naleśnikarnia, vege, wytrawne, słodkie', '2022-06-15 21:04:56'),
(12, 'Pizza Hut', 'Poznań, Aleje Solidarności 47', 0, 0, 'https://i.imgur.com/yFcEY9e.png', 0, 'Pizza Hut, Aleje Solidarności 47, pizza', '2022-06-15 21:06:40'),
(13, 'Max Burgers', 'Poznań, Hetmańska 1', 0, 0, 'https://www.maxpremiumburgers.pl/build/svg/logo-max.svg', 0, 'Max Burgers, Hetmańska 1, Burger', '2022-06-15 21:11:14'),
(14, 'Pyrabar', 'Strzelecka 13, 61-845 Poznań', 0, 0, 'https://storage.googleapis.com/glodny-prod/restaurants/fFsWoPvmDZkHJwCtUy/images/IMAGE_489.png', 0, 'Pyrabar, Strzelecka 13, 61-845 Poznań, pyra, Poznań, Poznan, tanio, jedzenie, ziemniaki, gzik', '2022-06-15 21:12:06'),
(15, 'United Chicken', 'Poznań, Św. Marcin 76', 0, 0, 'https://unitedchicken.pl/wp-content/uploads/2022/04/logo250.webp', 1, 'United Chicken, Św. Marcin 76, Kurczaczek', '2022-06-15 21:12:07');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `is_admin`, `created_at`) VALUES
(2, 'Admin', '4e7afebcfbae000b22c7c85e5560f89a2a0280b4', 1, '2022-06-15 20:40:14'),
(4, 'Jan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, '2022-06-15 21:02:39'),
(5, 'NiePaweł', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 0, '2022-06-15 21:05:36'),
(6, 'User', '9f8a2389a20ca0752aa9e95093515517e90e194c', 0, '2022-06-15 21:38:11');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT dla tabeli `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
