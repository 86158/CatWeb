-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 19 mei 2022 om 10:05
-- Serverversie: 10.4.21-MariaDB
-- PHP-versie: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catweb`
--
CREATE DATABASE IF NOT EXISTS `catweb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `catweb`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_favorites`
--

CREATE TABLE `site_favorites` (
  `ID` int(10) UNSIGNED NOT NULL,
  `ID_users` int(10) UNSIGNED NOT NULL,
  `ID_oefeningen` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `site_favorites`
--

INSERT INTO `site_favorites` (`ID`, `ID_users`, `ID_oefeningen`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_oefeningen`
--

CREATE TABLE `site_oefeningen` (
  `ID` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(245) NOT NULL,
  `type` set('Cardio','Power') DEFAULT NULL,
  `spiergroepen` set('biceps','') DEFAULT NULL,
  `duration` int(10) UNSIGNED DEFAULT NULL COMMENT 'In seconden',
  `calorien` mediumint(10) UNSIGNED DEFAULT NULL,
  `img` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `site_oefeningen`
--

INSERT INTO `site_oefeningen` (`ID`, `name`, `description`, `type`, `spiergroepen`, `duration`, `calorien`, `img`) VALUES
(1, 'Example', 'Niet bestaande oefening', 'Cardio,Power', 'biceps', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_schema`
--

CREATE TABLE `site_schema` (
  `ID` int(10) UNSIGNED NOT NULL,
  `ID_users` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_schemacontent`
--

CREATE TABLE `site_schemacontent` (
  `ID` int(10) UNSIGNED NOT NULL,
  `ID_schema` int(10) UNSIGNED NOT NULL,
  `ID_oefeningen` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_users`
--

CREATE TABLE `site_users` (
  `ID` int(10) UNSIGNED NOT NULL,
  `email` varchar(25) NOT NULL,
  `pwd` char(60) NOT NULL,
  `encryptedkey` varchar(120) NOT NULL,
  `token` mediumint(8) UNSIGNED DEFAULT NULL,
  `tokenTime` datetime DEFAULT NULL,
  `perms` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `username` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `postcode` char(6) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `site_users`
--

INSERT INTO `site_users` (`ID`, `email`, `pwd`, `encryptedkey`, `token`, `tokenTime`, `perms`, `username`, `street`, `postcode`, `city`, `country`) VALUES
(1, '86501@roc-teraa.nl', '$2y$10$LmQ9bC0a7S6LdBODQDUYa.Ctvxplv1dyOwKe9.wf84Agy99cf52Mi', '0G+rGrFVY3j4BGkPFmWbIUBRx5lLiPL+8lWSwP+R7+c=', 14164858, '2022-05-13 10:20:13', 1, 'ExampleUser', NULL, NULL, NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `site_favorites`
--
ALTER TABLE `site_favorites`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fav_oefening` (`ID_oefeningen`),
  ADD KEY `fav_user` (`ID_users`);

--
-- Indexen voor tabel `site_oefeningen`
--
ALTER TABLE `site_oefeningen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `site_schema`
--
ALTER TABLE `site_schema`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `schema_users` (`ID_users`);

--
-- Indexen voor tabel `site_schemacontent`
--
ALTER TABLE `site_schemacontent`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `schema_id` (`ID_schema`),
  ADD KEY `schema_oefening` (`ID_oefeningen`);

--
-- Indexen voor tabel `site_users`
--
ALTER TABLE `site_users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `site_favorites`
--
ALTER TABLE `site_favorites`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `site_oefeningen`
--
ALTER TABLE `site_oefeningen`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `site_schema`
--
ALTER TABLE `site_schema`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `site_users`
--
ALTER TABLE `site_users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `site_favorites`
--
ALTER TABLE `site_favorites`
  ADD CONSTRAINT `fav_oefening` FOREIGN KEY (`ID_oefeningen`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fav_user` FOREIGN KEY (`ID_users`) REFERENCES `site_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `site_schema`
--
ALTER TABLE `site_schema`
  ADD CONSTRAINT `schema_users` FOREIGN KEY (`ID_users`) REFERENCES `site_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `site_schemacontent`
--
ALTER TABLE `site_schemacontent`
  ADD CONSTRAINT `schema_id` FOREIGN KEY (`ID_schema`) REFERENCES `site_schema` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_oefening` FOREIGN KEY (`ID_oefeningen`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
