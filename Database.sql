-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 01 apr 2019 om 16:19
-- Serverversie: 10.3.7-MariaDB
-- PHP-versie: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `6in1 René Tielen`
--
CREATE DATABASE IF NOT EXISTS `6in1 René Tielen` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `6in1 René Tielen`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Comments`
--

CREATE TABLE `Comments` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Datum` datetime NOT NULL DEFAULT current_timestamp(),
  `Message` varchar(2000) NOT NULL,
  `PostId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `Comments`
--

INSERT INTO `Comments` (`Id`, `UserId`, `Datum`, `Message`, `PostId`) VALUES
(3, 42, '2019-03-31 13:16:48', 'don\'t you guys all agree?', 109),
(4, 43, '2019-03-31 13:19:40', 'True!!! EU4 is the best!!!', 109),
(5, 43, '2019-03-31 13:24:49', 'Nunu is love, Nunu is life! <3', 110),
(6, 42, '2019-03-31 13:26:50', 'I have to disagree sorry. any champion that dabs in their dance is stupid. an example of a better champion is Urgot. he is of course better then Nunu just look at his legs. More legs=better champion!', 110),
(7, 43, '2019-03-31 13:30:08', 'So you say that a man is actually beter than a woman in league of Legends? Just because a man has three legs and not two? This is a little bit sexist, so Nunu is still beter!', 110),
(8, 39, '2019-03-31 13:50:42', 'Very wise words, couldn\'t agree more!', 111);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Forum`
--

CREATE TABLE `Forum` (
  `Id` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` varchar(2000) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `Forum`
--

INSERT INTO `Forum` (`Id`, `Title`, `Description`, `UserId`) VALUES
(1, 'Grasmaaiers', 'Iamawookie', 0),
(2, 'Music', 'All kinds of music', 0),
(3, 'Gaming', 'Gaming', 0),
(4, 'Technology', 'For all kinds of information and discussions about technology', 0),
(5, 'Quotes', 'Forum for your favorite quotes', 0),
(6, 'Movies', 'talk about your favorite movies', 0),
(7, 'Series', 'forum where you can share your opinion on all kinds of series', 0),
(8, 'Nintendo Switch', 'Recommend your favorite games or discust other things on here', 0),
(17, 'Flat Earth Community', 'For all your flath earth needs', 42);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Likes`
--

CREATE TABLE `Likes` (
  `PostId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `Likes`
--

INSERT INTO `Likes` (`PostId`, `UserId`) VALUES
(104, 39),
(104, 37),
(104, 40),
(107, 39),
(108, 39),
(104, 42),
(107, 42),
(108, 42),
(109, 42),
(110, 43),
(111, 42),
(110, 39),
(112, 44),
(111, 44),
(108, 44),
(104, 44),
(113, 44),
(113, 45),
(114, 45);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `PersoonVolgen`
--

CREATE TABLE `PersoonVolgen` (
  `Volgend` int(11) NOT NULL,
  `Gevolgd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `PersoonVolgen`
--

INSERT INTO `PersoonVolgen` (`Volgend`, `Gevolgd`) VALUES
(32, 32),
(33, 33),
(34, 34),
(35, 35),
(36, 36),
(37, 37),
(37, 36),
(38, 38),
(40, 40),
(39, 39),
(40, 39),
(37, 39),
(41, 41),
(42, 42),
(43, 43),
(44, 44),
(45, 45),
(45, 44);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Post`
--

CREATE TABLE `Post` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `ForumId` int(11) NOT NULL,
  `Datum` datetime NOT NULL DEFAULT current_timestamp(),
  `Title` varchar(100) NOT NULL,
  `Message` varchar(4000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `Post`
--

INSERT INTO `Post` (`Id`, `UserId`, `ForumId`, `Datum`, `Title`, `Message`) VALUES
(104, 39, 1, '2019-03-27 14:35:46', 'Vroem Vroem Vroem', 'Grasmaaier zegt vroem vroem vroem'),
(107, 39, 3, '2019-03-31 12:56:41', 'Black Desert Online = RNG', 'For BDO you need to be RNG carried.\r\nOtherwise, it\'s unplayable'),
(108, 39, 7, '2019-03-31 13:00:27', 'Amazon\'s new Middle Earth Series', 'Amazon is creating a new series about Middle Earth.\r\n\r\nAmazon have confirmed that the show will be set in the Age of Númenor (or the Second Age). This is the 3,441 year period ahead of The Fellowship of the Ring.'),
(109, 42, 3, '2019-03-31 13:16:36', 'people should play more paradox games', 'like come on they are great games. why would anyone prefer stupid games like Black desert online over EU4 or HOI4.'),
(110, 43, 3, '2019-03-31 13:24:11', 'The best League of Legends champion is Nunu and Willump', 'We can all agree that our friendly, cozy and handsome Nunu is nice to look at and also is very usefull in the game. A good Snowball created by a Nunu and Willump player can save the game! Other champions are sometimes usefull as well, but you need a Nunu for that win. '),
(111, 42, 17, '2019-03-31 13:38:32', 'The earth is Flat', 'and anyone that says otherwise is drugged by Nasa to believe the world is a globe'),
(112, 44, 5, '2019-04-01 10:37:57', 'Inspiring', 'Vincit omnia veritas'),
(113, 44, 7, '2019-04-01 10:40:16', 'Friends', 'Friends is the funniest show ever, fight me!'),
(114, 45, 2, '2019-04-01 11:55:07', 'New I Prevail album', 'I Prevail\'s new album \'Trauma\' is out now guys!');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `User`
--

CREATE TABLE `User` (
  `Id` int(11) NOT NULL,
  `Username` varchar(16) NOT NULL,
  `EmailAdress` varchar(100) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Firstname` varchar(30) NOT NULL,
  `Lastname` varchar(40) NOT NULL,
  `Birthday` date NOT NULL,
  `Rank` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `User`
--

INSERT INTO `User` (`Id`, `Username`, `EmailAdress`, `Password`, `Firstname`, `Lastname`, `Birthday`, `Rank`) VALUES
(1, 'grasmaaier', 'mazzie@gmail.com', 'Grasmaaier123', 'Mazzie', 'Muildier', '2019-02-06', 0),
(37, 'yaboy', 'yaboy@yaboy.nl', 'Grasmaaier123', 'yaboy', 'yaboy', '1998-09-18', 1),
(38, 'BorisBeast', 'boris.muller25@gmail.com', '$2y$10$avpoxsFf86AsLsGPnr6J4uRLr3UxzJfo9fTdL6zKiroTDUbWFj0sC', 'Boris', 'Muller', '2001-09-20', 1),
(39, 'EldiarFTW', 'ThatRetGames@gmail.com', '$2y$10$0GzNmO12JkKAKK8aoeFa/O2J/mTP4f3OAeqLf8qWpNtx8sc0hn0Hy', 'René', 'Tielen', '2001-09-24', 1),
(40, 'TestUser', 'TestUser@readit.com', '$2y$10$9OYKHsrwWTldZhuNUk.W0e2fdru9480yFa4ysoVrQpXktAALQq7Qy', 'TestUser', 'TestUser', '2019-03-27', 1),
(42, 'AtomicViper31', 'cabriruben@gmail.com', '$2y$10$waPwKkXNvmZSsHJTs4UV8OLMbHbJoVYLlKo181ZpvpUAdDZc4mVVi', 'Ruben', 'Cabri', '2001-03-31', 0),
(43, 'Eu4god18', 'tiesvhe@gmail.com', '$2y$10$cgAvMIeCIonETlI4jeyhouSOuPcTAeAjTh3Jh3/y8ggylwooZhwf2', 'Ties', 'van het Erve', '2001-02-10', 0),
(44, 'Aideen', 'okok@gmail.com', '$2y$10$Fb/QZJCVfnetDSsTJrNUTu6TwYDzplnJ/Jert3C8/LLDQY9vhPSx.', 'Aideen', '', '2002-04-04', 0),
(45, 'DepressedBitch', 'lmao@gmail.com', '$2y$10$TDEsggsfyePS00jCVn3Eq.LYkTvNkJHyKaJhCxTF4Y03mtZsJrJza', 'Depressed', 'Bitch', '2001-04-01', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Volgen`
--

CREATE TABLE `Volgen` (
  `ForumId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `Volgen`
--

INSERT INTO `Volgen` (`ForumId`, `UserId`) VALUES
(1, 37),
(3, 39),
(2, 39),
(1, 39),
(7, 39),
(17, 42),
(3, 42),
(17, 39),
(3, 44),
(2, 44),
(7, 44);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `Forum`
--
ALTER TABLE `Forum`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `Likes`
--
ALTER TABLE `Likes`
  ADD KEY `FK_LUserId` (`UserId`),
  ADD KEY `FK_LPostId` (`PostId`);

--
-- Indexen voor tabel `Post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_UserId` (`UserId`),
  ADD KEY `FK_ForumId` (`ForumId`);

--
-- Indexen voor tabel `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `Volgen`
--
ALTER TABLE `Volgen`
  ADD KEY `FK_VForum` (`ForumId`),
  ADD KEY `FK_VUser` (`UserId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `Comments`
--
ALTER TABLE `Comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `Forum`
--
ALTER TABLE `Forum`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `Post`
--
ALTER TABLE `Post`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT voor een tabel `User`
--
ALTER TABLE `User`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `Likes`
--
ALTER TABLE `Likes`
  ADD CONSTRAINT `FK_LPostId` FOREIGN KEY (`PostId`) REFERENCES `Post` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_LUserId` FOREIGN KEY (`UserId`) REFERENCES `User` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `Post`
--
ALTER TABLE `Post`
  ADD CONSTRAINT `FK_ForumId` FOREIGN KEY (`ForumId`) REFERENCES `Forum` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_UserId` FOREIGN KEY (`UserId`) REFERENCES `User` (`Id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `Volgen`
--
ALTER TABLE `Volgen`
  ADD CONSTRAINT `FK_VForum` FOREIGN KEY (`ForumId`) REFERENCES `Forum` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_VUser` FOREIGN KEY (`UserId`) REFERENCES `User` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
