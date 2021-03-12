-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3307
-- Létrehozás ideje: 2021. Már 12. 12:50
-- Kiszolgáló verziója: 10.4.13-MariaDB
-- PHP verzió: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `szakdolgozat`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `badges`
--

DROP TABLE IF EXISTS `badges`;
CREATE TABLE IF NOT EXISTS `badges` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `userid` mediumint(9) NOT NULL,
  `badgeid` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- A tábla adatainak kiíratása `badges`
--

INSERT INTO `badges` (`id`, `userid`, `badgeid`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `feedbackid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `taskid` int(11) NOT NULL,
  `userid` mediumint(9) NOT NULL,
  `feedback` text COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`feedbackid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hints`
--

DROP TABLE IF EXISTS `hints`;
CREATE TABLE IF NOT EXISTS `hints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taskid` int(11) NOT NULL,
  `hint` mediumtext COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- A tábla adatainak kiíratása `hints`
--

INSERT INTO `hints` (`id`, `taskid`, `hint`) VALUES
(1, 1, 'Vizsgálja a bemenő értéket!\r\nif (feltétel):\r\n   ...'),
(2, 2, 'Írj egy ciklust, amely a stringen visszafelé lépked, így a karaktereket egyesével tudod elmenteni a változóba.');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createdBy` mediumint(9) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `description` text COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `tags` mediumtext COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- A tábla adatainak kiíratása `tasks`
--

INSERT INTO `tasks` (`id`, `createdBy`, `title`, `description`, `tags`, `verified`) VALUES
(1, 1, 'Víz halmazállapota', 'Írjon egy programot, amely a megadott hőmérséklet alapján megmondja, hogy milyen halmazállapotú a víz!\r\nInput: egész szám\r\nOutput: string\r\nLehetséges outputok: \'szilárd\', \'folyékony\', \'légnemű\'', 'feltétel,if', 0),
(2, 1, 'Visszafelé', 'Írjon egy programot, amely a bemeneti stringet visszafelé írja ki.\r\npl. kutya - aytuk', 'ciklus,for,reverse', 0),
(3, 1, 'Legkisebb és legnagyobb', 'Írjon egy programot, amely egy listából megadja a legkisebb és legnagyobb számot.\r\nInput: egész számok, szóközökkel választva\r\nOutput: legkisebb és legnagyobb szám, szóközzel választva', 'lista,min,max,keresés', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `testcase`
--

DROP TABLE IF EXISTS `testcase`;
CREATE TABLE IF NOT EXISTS `testcase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taskid` int(11) NOT NULL,
  `test_input` text COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `test_output` mediumtext COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `validator_input` mediumtext COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `validator_output` mediumtext COLLATE utf8mb4_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- A tábla adatainak kiíratása `testcase`
--

INSERT INTO `testcase` (`id`, `taskid`, `test_input`, `test_output`, `validator_input`, `validator_output`) VALUES
(1, 1, '25', 'folyékony', '-9', 'szilárd'),
(2, 1, '-35', 'szilárd', '158', 'légnemű'),
(3, 1, '124', 'légnemű', '34', 'folyékony'),
(4, 2, 'kutya', 'aytuk', 'malac', 'calam'),
(5, 2, '123', '321', '456', '654'),
(6, 2, 'két szó', 'ózs ték', 'három szavas mondat', 'tadnom savazs moráh'),
(7, 3, '4 5 3 9 8 1', '1 9', '2 8 4 6 3', '2 8'),
(8, 3, '6 4 25 84 3 9 41', '3 84', '1 4 85 67 52 11', '1 85'),
(9, 3, '4 7 -6 2 -12 2', '-12 7', '-15 6 9 8 5 33 12', '-15 33');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `experience` int(11) NOT NULL DEFAULT 0,
  `school` varchar(255) COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `currentBadge` smallint(5) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `remember_token`, `updated_at`, `created_at`, `admin`, `experience`, `school`, `currentBadge`) VALUES
(1, 'Dominik', '$2y$10$tNzFeEBaG748LFloM2FPmuTRPzdvIhuay.IGpMSPbGhmJLcMRcEFC', 'xq5tZzOxCqI4lm0LQbgWwa8q1Ciy0SXJuhUYBcTxT2s37VVu9tG7jut6XrVF', '2021-03-03 16:25:41', '2020-10-08 13:02:35', 0, 10000, 'pte ttk ddd asd', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `usertask`
--

DROP TABLE IF EXISTS `usertask`;
CREATE TABLE IF NOT EXISTS `usertask` (
  `userid` mediumint(8) UNSIGNED NOT NULL,
  `taskid` int(10) UNSIGNED NOT NULL,
  `points` tinyint(3) UNSIGNED DEFAULT NULL,
  `leftTime` smallint(6) DEFAULT NULL,
  `code` mediumtext COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `language` varchar(20) COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `usedHintIndex` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`taskid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
