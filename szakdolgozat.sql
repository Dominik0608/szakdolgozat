-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3307
-- Létrehozás ideje: 2021. Jan 08. 18:53
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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
  `feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`feedbackid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `feedbacks`
--

INSERT INTO `feedbacks` (`feedbackid`, `taskid`, `userid`, `feedback`, `date`) VALUES
(1, 11, 1, 'első feedback', '2020-11-09 13:57:12'),
(2, 11, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas quis egestas lectus. Morbi rhoncus libero ante, in pellentesque ipsum accumsan sed. Duis congue nulla sed turpis ultricies viverra. Sed sem felis, sagittis in sollicitudin id, dapibus ac lacus. Etiam consequat, est sit amet pharetra gravida, lacus orci interdum orci, quis semper dolor lacus sed lorem. Donec sed neque in eros interdum efficitur. Vivamus eget orci quis nulla rutrum iaculis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus sed tincidunt lorem, vitae egestas justo. Vestibulum sit amet condimentum mauris. Curabitur tincidunt diam at lorem aliquam, a faucibus sapien finibus. Sed nec bibendum libero. Cras vel leo eu ligula aliquam lacinia sit amet scelerisque nulla. Proin elementum dui in massa vulputate porta. Mauris sodales, justo in posuere accumsan, magna massa lacinia eros, eu lacinia purus risus in elit.', '2020-11-09 13:57:12'),
(3, 10, 1, '123', '2020-11-09 13:57:12'),
(4, 10, 1, '312', '2020-11-09 13:57:12'),
(5, 10, 1, '312', '2020-11-09 13:57:12'),
(6, 10, 1, 'tetszett', '2020-11-16 12:14:25'),
(7, 10, 1, 'tetszett a', '2020-11-16 12:14:32');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `hints`
--

DROP TABLE IF EXISTS `hints`;
CREATE TABLE IF NOT EXISTS `hints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taskid` int(11) NOT NULL,
  `hint` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `hints`
--

INSERT INTO `hints` (`id`, `taskid`, `hint`) VALUES
(2, 11, 'dsadsa'),
(4, 11, 'qweasd'),
(6, 13, 'asd'),
(7, 14, 'asd');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `log`
--

INSERT INTO `log` (`id`, `text`) VALUES
(1, '1 1'),
(2, '100'),
(3, '100'),
(4, '75'),
(5, '0'),
(6, '0'),
(7, '0'),
(8, '896'),
(9, '0');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createdBy` mediumint(9) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci NOT NULL,
  `tags` text DEFAULT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `tasks`
--

INSERT INTO `tasks` (`id`, `createdBy`, `title`, `description`, `tags`, `verified`) VALUES
(1, NULL, 'Első feladat', 'Első feladat leírása... de ez lehetne kicsit hosszabb is', NULL, 0),
(2, 1, 'Második feladat', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nec dignissim sem. Fusce faucibus arcu ac sem ultricies, vel ultrices augue venenatis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc faucibus dictum sem, et mattis ipsum blandit vel. Mauris congue, lacus at varius tincidunt, justo libero sodales ipsum, id maximus enim urna quis enim. Donec fringilla magna at ante dapibus, suscipit viverra nisl sagittis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget pretium nunc. Cras nec augue at ipsum mollis porttitor at a tortor. In tempus erat leo, interdum tincidunt mauris tempor vel.', NULL, 1),
(3, 2, 'harmadik', 'asdasdn jsdkajf gasdbkh fkbjladhsf bhjkas fakhjbasfhjbdsjbksd asjh', NULL, 1),
(4, NULL, 'negyedik', 'fsdnkfsdglkngfnlks gknljbf kjbs klbjf glbjksfdl gbsljk gbsdlfkg dbjg dfgdl kjbsg ', NULL, 0),
(5, NULL, 'qwewqeqew', 'ewqewqewqew', NULL, 0),
(6, 1, 'qweqeq', 'eqwe', NULL, 0),
(7, NULL, 'asdas', 'addsd', NULL, 0),
(8, NULL, 'qweqeqw', 'eqwe', NULL, 0),
(9, NULL, 'qweqeqw', 'eqwe', NULL, 0),
(10, NULL, 'dqwdq', 'qdqedqw', NULL, 0),
(11, 1, '4243212a', 'leírás', NULL, 0),
(12, 1, 'feladat keresés megoldása, kategóriák listázása (több kategória megadhatóság)', 'asd', NULL, 0),
(13, 1, 'feladat keresés megoldása, kategóriák listázása (több kategória megadhatóság)', 'tömb, függvény,', NULL, 0),
(14, 1, 'lehetőség szerint vissza nyíl a navbarra', 'asd', NULL, 0),
(15, 1, 'asd', 'asd', NULL, 0),
(17, 1, '123', '123', 'lista,függvények,valami hosszabb', 0),
(18, 1, 'asdqwe', 'qwe', 'lista,függvények,valami hosszabb', 0),
(19, 2, '11111', 'több soros teszt', 'több sor', 0),
(20, 2, '2222', '2222', '', 0),
(21, 2, '1', '1', '', 0),
(22, 1, '1', '1', '', 0),
(23, 1, '1', '1', '', 0),
(24, 2, 'a', '1', '', 0),
(25, 1, '1', '1', '', 0),
(26, 2, '1', '1', '', 0),
(27, 1, '1', '1', '', 0),
(28, 1, '1', '1', '', 0),
(29, 1, '1', '1', '', 0),
(30, 1, '1', '1', '', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `testcase`
--

DROP TABLE IF EXISTS `testcase`;
CREATE TABLE IF NOT EXISTS `testcase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taskid` int(11) NOT NULL,
  `test_input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `test_output` text CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `validator_input` text CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `validator_output` text CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `testcase`
--

INSERT INTO `testcase` (`id`, `taskid`, `test_input`, `test_output`, `validator_input`, `validator_output`) VALUES
(1, 8, 'eqweqw', 'qwe', 'wqqw', 'eqweqw'),
(2, 9, 'eewq', 'wqewq', 'ewq', 'ewq'),
(3, 10, 'as', 'as', 'fg', 'hhj'),
(4, 10, '123', '455', '67', '899'),
(5, 10, '12333', '32', '32', '32'),
(7, 11, 'asd', 'asd', 'das', 'das'),
(8, 11, '1', '2', '3', '4123'),
(9, 11, 'qewq', 'eqw', 'eqw', 'eqw'),
(11, 12, 'as', 'asd', 'dsa', 'dsa'),
(12, 12, 'dsa', 'dsa', 'dsa', 'das'),
(13, 13, 'asd', 'asd', 'asd', 'asd'),
(14, 13, 'asd', 'asd', 'asd', 'asd'),
(15, 14, 'asd', 'asd', 'asd', 'asd'),
(16, 14, 'asd', 'asd', 'asd', 'asd'),
(17, 15, 'asd', 'asd', 'asd', 'asd'),
(18, 15, 'a', 'a', 'a', 'a'),
(19, 16, '1', '1', '1', '1'),
(20, 16, '1', '1', '1', '1'),
(21, 17, '1', '1', '1', '1'),
(22, 17, '1', '1', '1', '1'),
(23, 18, 'a', 'a', 'a', 'a'),
(24, 18, 'a', 'a', 'a', 'a'),
(25, 19, '4\r\neee\r\neeeasdasddasű\r\n\r\naaaa', '1', '1', '1'),
(26, 19, 'dddd\r\nddd\r\ndd\r\nd\r\n1\r\n\r\n1111', '1', '1', '1'),
(27, 20, '3\r\na adsasddas aasdasda ds\r\nbd dsaads\r\nc asds  asdd asasd sa das d asdasd asd as', '2', '2', '2'),
(28, 20, '2', '2', '2', '2'),
(29, 21, '1', '1', '1', '1'),
(30, 21, '1', '1', '1', '1'),
(31, 22, '1', '1', '1', '1'),
(32, 22, '1', '1', '1', '1'),
(33, 23, '1', '1', '1', '1'),
(34, 23, '1', '1', '1', '1'),
(35, 24, '1', '1', '1', '1'),
(36, 24, '1', '1', '1', '1'),
(37, 25, '1', '1', '11', '1'),
(38, 25, '1', '1', '1', '1'),
(39, 26, '1', '1', '11', '1'),
(40, 26, '1', '1', '1', '1'),
(41, 27, '1', '1', '11', '1'),
(42, 27, '1', '1', '1', '1'),
(43, 28, '1', '1', '11', '1'),
(44, 28, '1', '1', '1', '1'),
(45, 29, '1', '1', '1', '1'),
(46, 29, '1', '1', '1', '1'),
(47, 30, '1', '1', '1', '1'),
(48, 30, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `experience` int(11) NOT NULL DEFAULT 0,
  `school` varchar(255) DEFAULT NULL,
  `currentBadge` smallint(5) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `remember_token`, `email`, `updated_at`, `created_at`, `admin`, `experience`, `school`, `currentBadge`) VALUES
(1, 'Dominik', '$2y$10$tNzFeEBaG748LFloM2FPmuTRPzdvIhuay.IGpMSPbGhmJLcMRcEFC', 'fkrdSOmIXyKmGmKPofNzDlaR1qaugIHriFszMAKcJwwe34Imp1eI9rCpDyBP', 'danko.dominik123@gmail.com', '2021-01-02 18:21:11', '2020-10-08 13:02:35', 0, 10000, 'pte ttk ddd', 1),
(2, 'asd', '$2y$10$Cz3201sEqtHu.1ESlsBWaup.Uw/vz4kHd/jRIQHFDPGF0tiFws24S', NULL, '123@qwe', '2020-10-08 14:24:48', '2020-10-08 14:24:48', 0, 0, NULL, 2),
(3, 'qwe', '$2y$10$6VWoG5BBwnPCe8kDh95Ck.ppcQ26hKedzlgT91pJDD9mkQ.sZlq06', NULL, 'danko.dominik123@gmail.coma', '2020-10-08 14:28:56', '2020-10-08 14:28:56', 0, 0, NULL, NULL),
(4, '123', '$2y$10$XU9XY7DefyK21bp492fAMezB.R4eAFKVAAaQ7tq3Li44l8ReZYc6K', NULL, 'danko.dominik123@gmail.comaa', '2020-10-08 14:32:16', '2020-10-08 14:32:16', 0, 1000, NULL, NULL),
(5, '123123', '$2y$10$GCTJFdqnivdcPWbKQKY/nu0cFSEvdrxcPNM4nqd6V8JeiX0.NGz0e', NULL, '123123@gmail.com', '2020-12-06 20:25:09', '2020-12-06 20:25:09', 0, 0, NULL, NULL);

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
  `code` text DEFAULT NULL,
  `language` varchar(20) DEFAULT NULL,
  `usedHintIndex` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`taskid`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `usertask`
--

INSERT INTO `usertask` (`userid`, `taskid`, `points`, `leftTime`, `code`, `language`, `usedHintIndex`) VALUES
(1, 8, 0, 0, 'a = input()\nprint(a)', 'python', 0),
(1, 10, 8, 0, 'a = input()\nprint(a)', 'python', 0),
(1, 11, 42, 0, 'a = input()\nprint(a)', 'python', 0),
(1, 19, 0, 0, 'lines = []\nwhile True:\n    line = input()\n    if line:\n        lines.append(line)\n    else:\n        break', 'python', 0),
(1, 20, 100, 896, 'a = input()\nprint(2)', 'python', 0),
(1, 21, 75, 0, 'a = input()\nprint(1)', 'python', 0),
(1, 24, 75, 0, 'a = input()\nprint(1)', 'python', 0),
(1, 26, 75, 0, 'a = input()\nprint(1)', 'python', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
