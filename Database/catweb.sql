-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2022 at 12:00 PM
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
-- Table structure for table `site_link_media`
--

DROP TABLE IF EXISTS `site_link_media`;
CREATE TABLE IF NOT EXISTS `site_link_media` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oefeningenID` int(10) UNSIGNED NOT NULL,
  `mediaID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `oefening_media_link` (`oefeningenID`),
  KEY `media_link` (`mediaID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_link_media`
--

REPLACE INTO `site_link_media` (`ID`, `oefeningenID`, `mediaID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10),
(11, 11, 11),
(12, 12, 12),
(13, 13, 13),
(14, 14, 14),
(15, 6, 15);

-- --------------------------------------------------------

--
-- Table structure for table `site_link_tube`
--

DROP TABLE IF EXISTS `site_link_tube`;
CREATE TABLE IF NOT EXISTS `site_link_tube` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oefeningenID` int(10) UNSIGNED NOT NULL,
  `mediaID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `oefening_tube_link` (`oefeningenID`),
  KEY `tube_link` (`mediaID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_link_tube`
--

REPLACE INTO `site_link_tube` (`ID`, `oefeningenID`, `mediaID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10),
(11, 11, 11),
(12, 12, 12),
(13, 13, 13),
(14, 14, 14),
(15, 6, 15);

-- --------------------------------------------------------

--
-- Table structure for table `site_link_workout`
--

DROP TABLE IF EXISTS `site_link_workout`;
CREATE TABLE IF NOT EXISTS `site_link_workout` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `workoutID` int(10) UNSIGNED NOT NULL,
  `oefeningID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Oefening ID` (`oefeningID`),
  KEY `Workout ID` (`workoutID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_link_workout`
--

REPLACE INTO `site_link_workout` (`ID`, `workoutID`, `oefeningID`) VALUES
(1, 1, 4),
(2, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `site_media`
--

DROP TABLE IF EXISTS `site_media`;
CREATE TABLE IF NOT EXISTS `site_media` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` varchar(145) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `image_links` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_media`
--

REPLACE INTO `site_media` (`ID`, `link`) VALUES
(6, 'https://3i133rqau023qjc1k3txdvr1-wpengine.netdna-ssl.com/wp-content/uploads/2014/08/V-Up_Exercise.jpg'),
(5, 'https://annawood.co.za/wp-content/uploads/2015/07/Anna_side_plank_seq2.jpg'),
(10, 'https://cdn-ami-drupal.heartyhosting.com/sites/muscleandfitness.com/files/studio/6101/6101_B.jpg'),
(13, 'https://cdn-ami-drupal.heartyhosting.com/sites/muscleandfitness.com/files/_main_highpull.jpg'),
(7, 'https://cdn.fitzport.com/wp-content/uploads/exercise/glutes/glute-kickback/glute-kickback-2-fitzport.com.jpg'),
(3, 'https://cdn.prod.openfit.com/uploads/2018/04/A-Open_Fit_Alt_Seated_Overhead_Tricep_Ex_770.jpg'),
(14, 'https://i.pinimg.com/originals/91/74/00/917400b311ef474be7cefe4a1de4ba3a.jpg'),
(1, 'https://i.stack.imgur.com/g8eij.jpg'),
(2, 'https://media3.popsugar-assets.com/files/2015/03/10/677/n/1922729/4dad4839_Triceps-Extensions-Red/i/Triceps-Kickback.jpg'),
(8, 'https://themovementfix.com/wp-content/uploads/2020/10/hip-extension-only.jpg'),
(15, 'https://www.crossfit.com/wp-content/uploads/2019/07/10131951/VuPKellyJackson.png'),
(12, 'https://www.goodfreephotos.com/albums/people/guy-doing-push-up.jpg'),
(11, 'https://www.gymguider.com/wp-content/uploads/2020/04/pike-press-up.jpg'),
(9, 'https://www.strongfitnessmag.com/wp-content/uploads/2017/06/Plank-Walkout-to-Push-Up.jpg'),
(4, 'https://www.topinspired.com/wp-content/uploads/2015/01/fire-hydrant.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `site_oefeningen`
--

DROP TABLE IF EXISTS `site_oefeningen`;
CREATE TABLE IF NOT EXISTS `site_oefeningen` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `type` enum('Kracht','Cardio') DEFAULT NULL,
  `spiergroepen` set('Triceps','Buik','Borst','Hamstrings','Rug','Schouders') DEFAULT NULL,
  `duration` int(10) UNSIGNED DEFAULT NULL COMMENT 'In seconden',
  `calorien` mediumint(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_oefeningen`
--

REPLACE INTO `site_oefeningen` (`ID`, `name`, `description`, `type`, `spiergroepen`, `duration`, `calorien`) VALUES
(1, 'Dumbbell One Arm Triceps Extension', 'Zoals de naam aangeeft, is de belangrijkste beweging het strekken van de armen (extensie). De uitvoering met dumbells zorgt voor grotere vrijheid in positie van de handen dan de variant met een halterstang. Ook is deze versie (in principe) veiliger omdat de gewichten naast het hoofd omlaag gebracht worden. In deze variant wordt de beweging afwisselend door beide armen uitgevoerd.', 'Kracht', 'Triceps', NULL, NULL),
(2, 'Standing Dumbbell Tricep Kickback', 'De triceps kickback is een isolatie oefening voor de triceps. Aangezien de triceps bij elke drukbeweging voor de borst betrokken zijn, is dit een effectieve oefening om puur de focus op de triceps te leggen. Ga rechts van een gewichtbankje staan met een dumbbell in je rechterhand en de handpalm naar binnen gericht. Plaats je linkerbeen en linkerhand op het uiteinde van de bank. Leun vanuit de heupen voorwaarts tot je bovenlichaam een hoek van 45 graden met de vloer komt. Je romp moet bijna parallel zijn aan de vloer. Zorg ervoor dat je je hoofd ook parallel houdt. Terwijl je de bovenarm stil houdt strek je de onderarm achter je tot de hele arm evenwijdig is aan de vloer en de dumbbell naar beneden wijst. Buig je arm weer langzaam om het gewicht weer te laten zakken.', 'Kracht', 'Triceps', NULL, NULL),
(3, 'Dumbbell Incline Triceps Extension', 'Zoals de naam aangeeft is de belangrijkste beweging het strekken van de armen (extensie). De uitvoering met dumbells zorgt voor grotere vrijheid in positie van de handen dan de variant met een halterstang. Ook is deze versie veiliger omdat de gewichten naast het hoofd omlaag gebracht worden. Het schuine bankje zorgt voor een grotere flexie van de schouders, de bovenarmen zijn meer richting het hoofd gericht dan in de variant op een plat bankje. Dit zorgt weer voor een grotere rek op de lange kop van de triceps.\nUitvoering:\n1. Ga met de gekozen dumbells (op de knieën geplaatst) op een schuin staand (incline) bankje zitten.\n2. Stoot de dumbells recht omhoog (zoals bij de dumbell chest press).\n3. Buig de armen door de dumbells gecontroleerd naar achteren en beneden te bewegen tot ongeveer naast je oren. Hou je bovenarmen hierbij op dezelfde plaats.\n4. Breng de dumbells weer omhoog door de armen te strekken. Voorkom in deze beweging de bovenarmen mee naar voren te brengen.\nVeiligheid:\n1. Deze oefening is een stuk zwaarder dan de dumbell chest press en shoulder press dus pak een relatief licht gewicht\n2. Hou je handen wijd genoeg. De dumbells steken uit van je handen en kunnen dus je hoofd sneller dan verwacht raken. Helemaal als je de versie met stang gewend bent.\nMogelijke alternatieven:\n • Barbell lying triceps extensions (skull crushers)\n • Dumbell lying triceps extensions (plat bankje)\n • Cable forward triceps extensions met touwen\n • Cable overhead triceps extensions met touwen', 'Kracht', 'Triceps,Schouders', NULL, NULL),
(4, 'Fire Hydrant', 'De dirty dog of fire hydrant is een oefening voor de bilspieren. Voor abductie van de benen (naar buiten bewegen vanaf de middellijn) worden alledrie de bilspieren ingeschakeld. Naast de gluteus maximus, medius en minimus wordt ook de tensor fasiae latae ingeschakeld. Deze spier aan de buitenkant van het dijbeen heeft namelijk naast het stabiliseren van het been tijdens staan en lopen ook abductie als functie. ', 'Kracht', 'Buik', NULL, NULL),
(5, 'Side Plank', 'Plank oefeningen zijn stabiliserende oefeningen. Door de houding van een plank moeten de spieren in de onderrug, buik, billen en benen (vooral hamstrings) werken om rug en benen uitgelijnd te houden.\nDoor de zijwaartse uitvoering komt in de buik meer nadruk te liggen op de schuine buikspieren. In de billen en benen betekent dit dat de nadruk verschuift naar de spieren die de benen naar binnen en buiten brengen, respectievelijk de ‘adductoren’ en ‘abductoren’.\nZeer simpel gesteld kan je zeggen dat de nadruk meer komt te liggen op spieren aan de buitenkant van het lichaam en minder op de voor en achterkant.', 'Cardio', 'Buik', NULL, NULL),
(6, 'V-up', 'De V-Up is een combinatie van de Sit Up en Lying Leg Raise. Het is een relatief moeilijke variant die vermeden zou moeten worden door beginners en/of mensen met lage rugklachten.\r\n\r\nDe rechte buikspier (de basis van het ‘wasbordje’) trekt het borstbeen richting het bekken door de rug te bollen. De schuine buikspieren in de zij stabiliseren de core door zijwaartse kantelingen en rotaties te remmen. De dwarse buikspieren (onder de schuine buikspieren) trekken de buikwand naar achteren en werken zo als een natuurlijke gewichthef riem om de core te stabiliseren.\r\n\r\nHeup-buigers in de benen en het bekken werken om de benen omhoog te brengen.', 'Kracht', 'Buik', NULL, NULL),
(7, 'Glute kickback', 'De zogenaamde Bird Dog is gericht op het in lijn brengen van het bovenbeen met het bovenlichaam. Dat is een functie van de bilspieren, hamstrings en de erector spinae. Dit is enigszins vergelijkbaar met een stiff legged deadlift. Nu wordt alleen het been in lijn gebracht van het bovenlichaam in plaats van andersom. Ook wordt dit in deze oefening afwisselend per been gedaan.\r\n\r\n', 'Kracht', 'Hamstrings', NULL, NULL),
(8, 'Hip Extension', 'Bij de hip extension duw je je billen omhoog om zo je bovenbenen en romp in één lijn te brengen. Voor deze actie zijn vooral de billen en hamstrings verantwoordelijk (behalve de buitenste kop van de biceps femoris). Andere spieren in de buik en langs de wervelkolom hebben vooral een stabiliserende werking.\r\n\r\n', 'Kracht', 'Hamstrings', NULL, NULL),
(9, 'Walk Out', 'Hoewel de oefening hier onder hamstrings vermeld staat, is het een full body (bodyweight) oefening. De hamstrings komen vooral samen met de billen en onderrug in actie tijdens het allerlaatste deel van de oefening dat vergelijkbaar is met een straight leg deadlift. Het is dus een relatief klein deel van de oefening dat je je op deze spieren richt en je voert het met lichaamsgewicht uit. Er zijn dus meer geschikte oefeningen op je hier specifiek op te trainen.\r\n\r\nZoek je echter naar een oefening om onderlichaam én bovenlichaam aan het werk te zetten dan is de walk out een optie. Tijdens het naar voren en terug lopen op de handen, zijn het vooral de schouders, borst en armspieren die in actie komen. Tijdens die beweging zijn de core-spieren actief om het lichaam te stabiliseren.\r\n\r\nDe walk out kan ook in een push up variant worden uitgevoerd waarbij de borst en triceps nog meer worden ingezet.', 'Kracht', 'Hamstrings', NULL, NULL),
(10, 'Single leg decline push up', 'De push up is een bekende samengestelde oefening voor het bovenlichaam en de corespieren. Door de houding van een plank moeten de spieren in de onderrug, billen en benen (vooral hamstrings) werken om rug en benen uitgelijnd te houden. Deze spieren hebben dus vooral een stabiliserende functie zoals ze dat in het dagelijkse leven ook vooral hebben.\nDe spieren in de borst (vooral pectoralis major), schouders (vooral voorkant) en armen (vooral triceps) hebben een actievere rol. De borst- en schouderspieren werken hard om de bovenarmen naar voren te trekken terwijl de triceps in actie komen om de armen te strekken.\nIn deze ‘decline’ variant komt (relatief) meer nadruk te liggen op de bovenste vezels van de borstspieren en op de voorkant van de schouders. Doordat bovendien minder gewicht door de voeten wordt gedragen, is deze variant zwaarder dan de normale push up.\nDoor een been op te tillen, komt  onder andere meer nadruk te liggen op de rectus femoris van het steunende been. De buitenste schuine buikspieren moeten bovendien harder werken om je lichaam te stabiliseren. De billen en hamstrings moeten nu ook werken om het opgeheven been omhoog te houden', 'Kracht', 'Borst', NULL, NULL),
(11, 'Pike Push-up', 'De pike push up, ook Pike press genoemd zit qua oefening ergens tussen een shoulder press en een push up. Of anders gezegd; tussen een handstand push up en een normale push up. Een handstand push up is immers een shoulder press met het lichaamsgewicht als weerstand. Door de aangepaste hoek komt dan ook meer nadruk op de schouders te liggen en bovenste vezels van de borst. Op de middelste en onderste vezels komt juist minder nadruk te liggen.\r\n\r\nDe pike push up brengt het bovenlichaam bijna in de houding van de handstand push up terwijl de voeten het contact met de vloer behouden. Behalve dat hierdoor minder gewicht gedragen wordt, kunnen ook de borstspieren actiever bijdragen dan in een handstand.\r\n\r\nHoewel lichter dan een handstand push up is de pike push up een stuk zwaarder dan normaal opdrukken. Begin daarom vanuit een normale push up waarbij je de afstand tussen handen en voeten in kleine stappen vergroot. Zorg ook voor een zacht oppervlak of een kussen.', 'Kracht', 'Borst', NULL, NULL),
(12, 'Push ups / Opdrukken', 'De push up is een bekende samengestelde oefening voor het bovenlichaam en de corespieren. Door de houding van een plank moeten de spieren in de onderrug, billen en benen (vooral hamstrings) werken om rug en benen uitgelijnd te houden. Deze spieren hebben dus vooral een stabiliserende functie zoals ze dat in het dagelijkse leven ook vooral hebben.\r\n\r\nDe spieren in de borst (vooral pectoralis major), schouders (vooral voorkant) en armen (vooral triceps) hebben een actievere rol. De borst- en schouderspieren werken hard om de bovenarmen naar voren te trekken terwijl de triceps in actie komen om de armen te strekken.\r\n\r\nEen wijde stand van de handen zorgt voor meer inzet van de borst terwijl een smallere stand meer van de triceps en schouders vereist.', 'Kracht', 'Borst', NULL, NULL),
(13, 'Dumbbell High Row', 'Alle zogenaamde row of roei-oefeningen, zijn voornamelijk gericht op het naar achteren trekken van de bovenarmen. Dit is een van de belangrijkste functies van de latissimus dorsi, de grote rugspier. Om deze functie met losse gewichten uit te voeren moet het bovenlichaam in (bijna) horizontale positie gebracht worden zodat de zwaartekracht de juiste weerstand kan verzorgen. In deze variant doe je dat door voorover te buigen over een bankje, steunend op één arm.\r\n\r\nHet verschil met de normale dumbell row is dat de ellebogen in de high row niet langs de zij maar naar buiten omhoog worden getrokken (abductie van de schouder). De handen zijn dan ook in een geproneerde positie, met de palmen naar onderen/achter gericht.\r\n\r\nOmdat de bovenarm haaks aan de romp naar achteren (ten opzichte van de romp) wordt getrokken, is hier een grotere rol voor de schouderspier de deltoideus (vooral achterkant) en de kleinere spieren van de rotatorenmanchet die de schouder moeten stabiliseren.', 'Kracht', 'Rug', NULL, NULL),
(14, 'Rear Decline Bridge', 'De rear decline bridge / glute bridge is gericht op het strekken van de rug en het in lijn brengen van het bovenlichaam met het onderlichaam. Een functie van de erector spinae in de rug, de bilspieren en hamstrings. Deze oefening past dan ook net zozeer binnen een training voor de billen. De billen werken het hardst in deze oefening. Een goede oefening om de onderrug in het algemeen te trainen ter preventie blessures. En voor mooiere billen natuurlijk.', 'Kracht', 'Rug', NULL, NULL);

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
-- Table structure for table `site_tube`
--

DROP TABLE IF EXISTS `site_tube`;
CREATE TABLE IF NOT EXISTS `site_tube` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` varchar(15) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `tube_links` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_tube`
--

REPLACE INTO `site_tube` (`ID`, `link`) VALUES
(9, '-FW8DNKsAh8'),
(15, '0UIS7TDHMQU'),
(6, '7UVgs18Y1P4'),
(10, 'gbFiLWpt-YM'),
(2, 'HjlgKNAqD8k'),
(8, 'i4rmRxPBmkY'),
(3, 'lwqhMCTg2Nw'),
(7, 'MB8LoopNjPE'),
(5, 'N_s9em1xTqU'),
(12, 'P3D2PPMYWjk'),
(13, 's9eW5yyZKOY'),
(1, 'Vs0k_0y1A1E'),
(11, 'x7_I5SUAd00'),
(14, 'y7kU3OvDwTM'),
(4, 'ZVfcRHhcBgg');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_users`
--

REPLACE INTO `site_users` (`ID`, `email`, `username`, `pwd`, `encryptedkey`, `token`, `tokenTime`, `perms`) VALUES
(1, '86501@roc-teraa.nl', 'ExampleUser', '$2y$10$LmQ9bC0a7S6LdBODQDUYa.Ctvxplv1dyOwKe9.wf84Agy99cf52Mi', '0G+rGrFVY3j4BGkPFmWbIUBRx5lLiPL+8lWSwP+R7+c=', NULL, NULL, 1),
(2, 'jurienbraat2002@gmail.com', 'Deadvire', '$2y$10$QVDivmLX53f2dW4HvA4EqeO62hvYuUC64oZZ1c3OtBMYib6UzkZyS', 'NQd636GWtEfkS/M0EWe+Ul42F2K3JTbwgyFiAZ9AjpP6richgSdbSI0XRuCsJTJ54+vVMlRkeSmciHvTEz0oHg==', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `site_workout`
--

DROP TABLE IF EXISTS `site_workout`;
CREATE TABLE IF NOT EXISTS `site_workout` (
  `workoutID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `workTitle` varchar(30) NOT NULL,
  `Beschrijving` text NOT NULL,
  PRIMARY KEY (`workoutID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_workout`
--

REPLACE INTO `site_workout` (`workoutID`, `workTitle`, `Beschrijving`) VALUES
(1, 'Cardio', 'Hier is een tekst om in te vullen waarbij cardio als deze workout hoofddoel wordt gebruikt'),
(2, 'Kracht', 'Hier is een tekst om in te vullen waarbij kracht als deze workout hoofddoel wordt gebruikt');

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
-- Constraints for table `site_link_media`
--
ALTER TABLE `site_link_media`
  ADD CONSTRAINT `media_link` FOREIGN KEY (`mediaID`) REFERENCES `site_media` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `oefening_media_link` FOREIGN KEY (`oefeningenID`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `site_link_tube`
--
ALTER TABLE `site_link_tube`
  ADD CONSTRAINT `oefening_tube_link` FOREIGN KEY (`oefeningenID`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tube_link` FOREIGN KEY (`mediaID`) REFERENCES `site_tube` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `site_link_workout`
--
ALTER TABLE `site_link_workout`
  ADD CONSTRAINT `Oefening ID` FOREIGN KEY (`oefeningID`) REFERENCES `site_oefeningen` (`ID`),
  ADD CONSTRAINT `Workout ID` FOREIGN KEY (`workoutID`) REFERENCES `site_workout` (`workoutID`);

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
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_favorites', '{\"sorted_col\":\"`site_favorites`.`ID` ASC\"}', '2022-06-13 09:57:22');

--
-- Metadata for table site_link_media
--

--
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_link_media', '{\"sorted_col\":\"`site_link_media`.`ID` ASC\"}', '2022-06-01 08:58:04');

--
-- Metadata for table site_link_tube
--

--
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_link_tube', '{\"sorted_col\":\"`site_link_tube`.`ID` ASC\"}', '2022-06-01 08:58:06');

--
-- Metadata for table site_link_workout
--

--
-- Metadata for table site_media
--

--
-- Dumping data for table `pma__column_info`
--

REPLACE INTO `pma__column_info` (`db_name`, `table_name`, `column_name`, `comment`, `mimetype`, `transformation`, `transformation_options`, `input_transformation`, `input_transformation_options`) VALUES
('catweb', 'site_media', 'link', '', 'text_plain', 'output/text_plain_imagelink.php', '', '', '');

--
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_media', '{\"sorted_col\":\"`site_media`.`ID` ASC\"}', '2022-06-01 08:58:07');

--
-- Metadata for table site_oefeningen
--

--
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_oefeningen', '{\"sorted_col\":\"`site_oefeningen`.`ID` ASC\"}', '2022-06-13 07:42:26');

--
-- Metadata for table site_schema
--

--
-- Metadata for table site_schemacontent
--

--
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_schemacontent', '{\"sorted_col\":\"`site_schemacontent`.`ID` ASC\"}', '2022-06-07 09:17:04');

--
-- Metadata for table site_tube
--

--
-- Dumping data for table `pma__column_info`
--

REPLACE INTO `pma__column_info` (`db_name`, `table_name`, `column_name`, `comment`, `mimetype`, `transformation`, `transformation_options`, `input_transformation`, `input_transformation_options`) VALUES
('catweb', 'site_tube', 'link', '', 'text_plain', 'text_plain_link.php', '\'https://youtu.be/\'', '', '');

--
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_tube', '{\"sorted_col\":\"`site_tube`.`ID` ASC\"}', '2022-06-13 07:52:15');

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
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_users', '{\"sorted_col\":\"`site_users`.`ID` ASC\"}', '2022-06-13 07:50:08');

--
-- Metadata for table site_workout
--

--
-- Dumping data for table `pma__table_uiprefs`
--

REPLACE INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'catweb', 'site_workout', '{\"sorted_col\":\"`site_workout`.`workoutID` ASC\"}', '2022-06-07 09:16:28');

--
-- Metadata for database catweb
--
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
