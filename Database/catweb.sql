-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2022 at 11:56 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET FOREIGN_KEY_CHECKS=0;
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
-- Table structure for table `site_favorites`
--

DROP TABLE IF EXISTS `site_favorites`;
CREATE TABLE IF NOT EXISTS `site_favorites` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ID_users` int(10) UNSIGNED NOT NULL,
  `ID_oefeningen` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fav_oefening` (`ID_oefeningen`),
  KEY `fav_user` (`ID_users`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_favorites`
--

REPLACE INTO `site_favorites` (`ID`, `ID_users`, `ID_oefeningen`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_schema`
--

DROP TABLE IF EXISTS `site_schema`;
CREATE TABLE IF NOT EXISTS `site_schema` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ID_users` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `schema_users` (`ID_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_schemacontent`
--

DROP TABLE IF EXISTS `site_schemacontent`;
CREATE TABLE IF NOT EXISTS `site_schemacontent` (
  `ID` int(10) UNSIGNED NOT NULL,
  `ID_schema` int(10) UNSIGNED NOT NULL,
  `ID_oefeningen` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `schema_id` (`ID_schema`),
  KEY `schema_oefening` (`ID_oefeningen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_users`
--

DROP TABLE IF EXISTS `site_users`;
CREATE TABLE IF NOT EXISTS `site_users` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(25) NOT NULL COMMENT 'Regex validation from: https://www.rhyous.com/2010/06/15/csharp-email-regular-expression',
  `username` varchar(100) DEFAULT NULL,
  `pwd` char(60) NOT NULL,
  `encryptedkey` varchar(120) NOT NULL,
  `token` mediumint(8) UNSIGNED DEFAULT NULL,
  `tokenTime` datetime DEFAULT NULL,
  `perms` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `usernames` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_users`
--

REPLACE INTO `site_users` (`ID`, `email`, `username`, `pwd`, `encryptedkey`, `token`, `tokenTime`, `perms`) VALUES
(1, '86501@roc-teraa.nl', 'ExampleUser', '$2y$10$LmQ9bC0a7S6LdBODQDUYa.Ctvxplv1dyOwKe9.wf84Agy99cf52Mi', '0G+rGrFVY3j4BGkPFmWbIUBRx5lLiPL+8lWSwP+R7+c=', 14164858, '2022-05-13 10:20:13', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `site_favorites`
--
ALTER TABLE `site_favorites`
  ADD CONSTRAINT `fav_oefening` FOREIGN KEY (`ID_oefeningen`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fav_user` FOREIGN KEY (`ID_users`) REFERENCES `site_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `site_schema`
--
ALTER TABLE `site_schema`
  ADD CONSTRAINT `schema_users` FOREIGN KEY (`ID_users`) REFERENCES `site_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `site_schemacontent`
--
ALTER TABLE `site_schemacontent`
  ADD CONSTRAINT `schema_id` FOREIGN KEY (`ID_schema`) REFERENCES `site_schema` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schema_oefening` FOREIGN KEY (`ID_oefeningen`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Metadata
--
USE `phpmyadmin`;

--
-- Metadata for table site_favorites
--

--
-- Metadata for table site_schema
--

--
-- Metadata for table site_schemacontent
--

--
-- Metadata for table site_users
--

--
-- Dumping data for table `pma__column_info`
--

REPLACE INTO `pma__column_info` (`db_name`, `table_name`, `column_name`, `comment`, `mimetype`, `transformation`, `transformation_options`, `input_transformation`, `input_transformation_options`) VALUES
('catweb', 'site_users', 'email', '', 'text_plain', '', '', 'Input/Text_Plain_RegexValidation.php', '\\A[\\w!#$%&\'*+\\-\\/=?\\^_`{|}~]+(?:\\.[\\w!#$%&\'*+\\-\\/=?\\^_`{|}~]+)*@(?:(?:(?:[\\-\\w]+\\.)+[a-zA-Z]{2,4})|(?:(?:[0-9]{1,3}\\.){3}[0-9]{1,3}))\\z'),
('catweb', 'site_users', 'perms', '', '', 'output/text_plain_bool2text.php', '', '', ''),
('catweb', 'site_users', 'tokenTime', '', 'text_plain', 'output/text_plain_dateformat.php', '', '', '');

--
-- Metadata for database catweb
--
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
