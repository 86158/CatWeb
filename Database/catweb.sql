-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2022 at 09:54 AM
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
CREATE TABLE `site_favorites` (
  `ID` int(10) UNSIGNED NOT NULL,
  `ID_users` int(10) UNSIGNED NOT NULL,
  `ID_oefeningen` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_favorites`
--

INSERT INTO `site_favorites` (`ID`, `ID_users`, `ID_oefeningen`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_oefeningen`
--

DROP TABLE IF EXISTS `site_oefeningen`;
CREATE TABLE `site_oefeningen` (
  `ID` int(10) UNSIGNED NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `type` set('Kracht','Cardio') DEFAULT NULL,
  `spiergroepen` set('Triceps','Buik','Borst','Hamstrings','Rug') DEFAULT NULL,
  `duration` int(10) UNSIGNED DEFAULT NULL COMMENT 'In seconden',
  `calorien` mediumint(10) UNSIGNED DEFAULT NULL,
  `img` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_oefeningen`
--

INSERT INTO `site_oefeningen` (`ID`, `name`, `description`, `type`, `spiergroepen`, `duration`, `calorien`, `img`) VALUES
(1, 'Dumbbell One Arm Triceps Extension', 'Zoals de naam aangeeft, is de belangrijkste beweging het strekken van de armen (extensie). De uitvoering met dumbells zorgt voor grotere vrijheid in positie van de handen dan de variant met een halterstang. Ook is deze versie (in principe) veiliger omdat de gewichten naast het hoofd omlaag gebracht worden. In deze variant wordt de beweging afwisselend door beide armen uitgevoerd.', 'Kracht', 'Triceps', NULL, NULL, NULL),
(2, 'Standing Dumbbell Tricep Kickback', 'De triceps kickback is een isolatie oefening voor de triceps. Aangezien de triceps bij elke drukbeweging voor de borst betrokken zijn, is dit een effectieve oefening om puur de focus op de triceps te leggen. Ga rechts van een gewichtbankje staan met een dumbbell in je rechterhand en de handpalm naar binnen gericht. Plaats je linkerbeen en linkerhand op het uiteinde van de bank. Leun vanuit de heupen voorwaarts tot je bovenlichaam een hoek van 45 graden met de vloer komt. Je romp moet bijna parallel zijn aan de vloer. Zorg ervoor dat je je hoofd ook parallel houdt. Terwijl je de bovenarm stil houdt strek je de onderarm achter je tot de hele arm evenwijdig is aan de vloer en de dumbbell naar beneden wijst. Buig je arm weer langzaam om het gewicht weer te laten zakken.', 'Kracht', 'Triceps', NULL, NULL, NULL),
(3, 'Dumbbell Incline Triceps Extension', 'Dumbell Incline Triceps Extensions Actieve spieren: -Triceps -Schouders (stabiliserend) Zoals de naam aangeeft is de belangrijkste beweging het strekken van de armen (extensie). De uitvoering met dumbells zorgt voor grotere vrijheid in positie van de handen dan de variant met een halterstang. Ook is deze versie veiliger omdat de gewichten naast het hoofd omlaag gebracht worden. Het schuine bankje zorgt voor een grotere flexie van de schouders, de bovenarmen zijn meer richting het hoofd gericht dan in de variant op een plat bankje. Dit zorgt weer voor een grotere rek op de lange kop van de triceps.  Uitvoering: 1. Ga met de gekozen dumbells (op de knieën geplaatst) op een schuin staand (‘incline’) bankje zitten. 2. Stoot de dumbells recht omhoog (zoals bij de dumbell chest press). 3. Buig de armen door de dumbells gecontroleerd naar achteren en beneden te bewegen tot ongeveer naast je oren. Hou je bovenarmen hierbij op dezelfde plaats. 4. Breng de dumbells weer omhoog door de armen te strekken. Voorkom in deze beweging de bovenarmen mee naar voren te brengen. Veiligheid: 1. Deze oefening is een stuk zwaarder dan de dumbell chest press en shoulder press dus pak een relatief licht gewicht 2. Hou je handen wijd genoeg. De dumbells steken uit van je handen en kunnen dus je hoofd sneller dan verwacht raken. Helemaal als je de versie met stang gewend bent.  Mogelijke alternatieven: • Barbell lying triceps extensions (‘skull crushers’) • Dumbell lying triceps extensions (plat bankje) • Cable forward triceps extensions met touwen • Cable overhead triceps extensions met touwen', 'Kracht', 'Triceps', NULL, NULL, NULL),
(4, 'Fire Hydrant', 'De dirty dog of fire hydrant is een oefening voor de bilspieren. Voor abductie van de benen (naar buiten bewegen vanaf de middellijn) worden alledrie de bilspieren ingeschakeld. Naast de gluteus maximus, medius en minimus wordt ook de tensor fasiae latae ingeschakeld. Deze spier aan de buitenkant van het dijbeen heeft namelijk naast het stabiliseren van het been tijdens staan en lopen ook abductie als functie. ', 'Kracht', 'Buik', NULL, NULL, NULL),
(5, 'Side Plank', 'Plank oefeningen zijn stabiliserende oefeningen. Door de houding van een plank moeten de spieren in de onderrug, buik, billen en benen (vooral hamstrings) werken om rug en benen uitgelijnd te houden.\r\n\r\nDoor de zijwaartse uitvoering komt in de buik meer nadruk te liggen op de schuine buikspieren. In de billen en benen betekent dit dat de nadruk verschuift naar de spieren die de benen naar binnen en buiten brengen, respectievelijk de ‘adductoren’ en ‘abductoren’.\r\n\r\nZeer simpel gesteld kan je zeggen dat de nadruk meer komt te liggen op spieren aan de buitenkant van het lichaam en minder op de voor en achterkant.', 'Cardio', 'Buik', NULL, NULL, NULL),
(6, 'V-up', 'De V-Up is een combinatie van de Sit Up en Lying Leg Raise. Het is een relatief moeilijke variant die vermeden zou moeten worden door beginners en/of mensen met lage rugklachten.\r\n\r\nDe rechte buikspier (de basis van het ‘wasbordje’) trekt het borstbeen richting het bekken door de rug te bollen. De schuine buikspieren in de zij stabiliseren de core door zijwaartse kantelingen en rotaties te remmen. De dwarse buikspieren (onder de schuine buikspieren) trekken de buikwand naar achteren en werken zo als een natuurlijke gewichthef riem om de core te stabiliseren.\r\n\r\nHeup-buigers in de benen en het bekken werken om de benen omhoog te brengen.', 'Kracht', 'Buik', NULL, NULL, NULL),
(7, 'Glute kickback', 'De zogenaamde Bird Dog is gericht op het in lijn brengen van het bovenbeen met het bovenlichaam. Dat is een functie van de bilspieren, hamstrings en de erector spinae. Dit is enigszins vergelijkbaar met een stiff legged deadlift. Nu wordt alleen het been in lijn gebracht van het bovenlichaam in plaats van andersom. Ook wordt dit in deze oefening afwisselend per been gedaan.\r\n\r\n', 'Kracht', 'Hamstrings', NULL, NULL, NULL),
(8, 'Hip Extension', 'Bij de hip extension duw je je billen omhoog om zo je bovenbenen en romp in één lijn te brengen. Voor deze actie zijn vooral de billen en hamstrings verantwoordelijk (behalve de buitenste kop van de biceps femoris). Andere spieren in de buik en langs de wervelkolom hebben vooral een stabiliserende werking.\r\n\r\n', 'Kracht', 'Hamstrings', NULL, NULL, NULL),
(9, 'Walk Out', 'Hoewel de oefening hier onder hamstrings vermeld staat, is het een full body (bodyweight) oefening. De hamstrings komen vooral samen met de billen en onderrug in actie tijdens het allerlaatste deel van de oefening dat vergelijkbaar is met een straight leg deadlift. Het is dus een relatief klein deel van de oefening dat je je op deze spieren richt en je voert het met lichaamsgewicht uit. Er zijn dus meer geschikte oefeningen op je hier specifiek op te trainen.\r\n\r\nZoek je echter naar een oefening om onderlichaam én bovenlichaam aan het werk te zetten dan is de walk out een optie. Tijdens het naar voren en terug lopen op de handen, zijn het vooral de schouders, borst en armspieren die in actie komen. Tijdens die beweging zijn de core-spieren actief om het lichaam te stabiliseren.\r\n\r\nDe walk out kan ook in een push up variant worden uitgevoerd waarbij de borst en triceps nog meer worden ingezet.', 'Kracht', 'Hamstrings', NULL, NULL, NULL),
(10, 'Single leg decline push up', 'De push up is een bekende samengestelde oefening voor het bovenlichaam en de corespieren. Door de houding van een plank moeten de spieren in de onderrug, billen en benen (vooral hamstrings) werken om rug en benen uitgelijnd te houden. Deze spieren hebben dus vooral een stabiliserende functie zoals ze dat in het dagelijkse leven ook vooral hebben.\r\n\r\nDe spieren in de borst (vooral pectoralis major), schouders (vooral voorkant) en armen (vooral triceps) hebben een actievere rol. De borst- en schouderspieren werken hard om de bovenarmen naar voren te trekken terwijl de triceps in actie komen om de armen te strekken.\r\n\r\nIn deze ‘decline’ variant komt (relatief) meer nadruk te liggen op de bovenste vezels van de borstspieren en op de voorkant van de schouders. Doordat bovendien minder gewicht door de voeten wordt gedragen, is deze variant zwaarder dan de normale push up.\r\n\r\nDoor een been op te tillen, komt  onder andere meer nadruk te liggen op de rectus femoris van het steunende been. De buitenste schuine buikspieren moeten bovendien harder werken om je lichaam te stabiliseren. De billen en hamstrings moeten nu ook werken om het opgeheven been omhoog te houden', 'Kracht', 'Borst', NULL, NULL, NULL),
(11, 'Pike Push-up', 'De pike push up, ook Pike press genoemd zit qua oefening ergens tussen een shoulder press en een push up. Of anders gezegd; tussen een handstand push up en een normale push up. Een handstand push up is immers een shoulder press met het lichaamsgewicht als weerstand. Door de aangepaste hoek komt dan ook meer nadruk op de schouders te liggen en bovenste vezels van de borst. Op de middelste en onderste vezels komt juist minder nadruk te liggen.\r\n\r\nDe pike push up brengt het bovenlichaam bijna in de houding van de handstand push up terwijl de voeten het contact met de vloer behouden. Behalve dat hierdoor minder gewicht gedragen wordt, kunnen ook de borstspieren actiever bijdragen dan in een handstand.\r\n\r\nHoewel lichter dan een handstand push up is de pike push up een stuk zwaarder dan normaal opdrukken. Begin daarom vanuit een normale push up waarbij je de afstand tussen handen en voeten in kleine stappen vergroot. Zorg ook voor een zacht oppervlak of een kussen.', 'Kracht', 'Borst', NULL, NULL, NULL),
(12, 'Push ups / Push ups / Opdrukken', 'De push up is een bekende samengestelde oefening voor het bovenlichaam en de corespieren. Door de houding van een plank moeten de spieren in de onderrug, billen en benen (vooral hamstrings) werken om rug en benen uitgelijnd te houden. Deze spieren hebben dus vooral een stabiliserende functie zoals ze dat in het dagelijkse leven ook vooral hebben.\r\n\r\nDe spieren in de borst (vooral pectoralis major), schouders (vooral voorkant) en armen (vooral triceps) hebben een actievere rol. De borst- en schouderspieren werken hard om de bovenarmen naar voren te trekken terwijl de triceps in actie komen om de armen te strekken.\r\n\r\nEen wijde stand van de handen zorgt voor meer inzet van de borst terwijl een smallere stand meer van de triceps en schouders vereist.', 'Kracht', 'Borst', NULL, NULL, NULL),
(13, 'Dumbbell High Row', 'Alle zogenaamde row of roei-oefeningen, zijn voornamelijk gericht op het naar achteren trekken van de bovenarmen. Dit is een van de belangrijkste functies van de latissimus dorsi, de grote rugspier. Om deze functie met losse gewichten uit te voeren moet het bovenlichaam in (bijna) horizontale positie gebracht worden zodat de zwaartekracht de juiste weerstand kan verzorgen. In deze variant doe je dat door voorover te buigen over een bankje, steunend op één arm.\r\n\r\nHet verschil met de normale dumbell row is dat de ellebogen in de high row niet langs de zij maar naar buiten omhoog worden getrokken (abductie van de schouder). De handen zijn dan ook in een geproneerde positie, met de palmen naar onderen/achter gericht.\r\n\r\nOmdat de bovenarm haaks aan de romp naar achteren (ten opzichte van de romp) wordt getrokken, is hier een grotere rol voor de schouderspier de deltoideus (vooral achterkant) en de kleinere spieren van de rotatorenmanchet die de schouder moeten stabiliseren.', 'Kracht', 'Rug', NULL, NULL, NULL),
(14, 'Rear Decline Bridge', 'De rear decline bridge / glute bridge is gericht op het strekken van de rug en het in lijn brengen van het bovenlichaam met het onderlichaam. Een functie van de erector spinae in de rug, de bilspieren en hamstrings. Deze oefening past dan ook net zozeer binnen een training voor de billen. De billen werken het hardst in deze oefening. Een goede oefening om de onderrug in het algemeen te trainen ter preventie blessures. En voor mooiere billen natuurlijk.', 'Kracht', 'Rug', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_schema`
--

DROP TABLE IF EXISTS `site_schema`;
CREATE TABLE `site_schema` (
  `ID` int(10) UNSIGNED NOT NULL,
  `ID_users` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_schemacontent`
--

DROP TABLE IF EXISTS `site_schemacontent`;
CREATE TABLE `site_schemacontent` (
  `ID` int(10) UNSIGNED NOT NULL,
  `ID_schema` int(10) UNSIGNED NOT NULL,
  `ID_oefeningen` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_users`
--

DROP TABLE IF EXISTS `site_users`;
CREATE TABLE `site_users` (
  `ID` int(10) UNSIGNED NOT NULL,
  `email` varchar(25) NOT NULL COMMENT 'Regex validation from: https://www.rhyous.com/2010/06/15/csharp-email-regular-expression',
  `username` varchar(100) DEFAULT NULL,
  `pwd` char(60) NOT NULL,
  `encryptedkey` varchar(120) NOT NULL,
  `token` mediumint(8) UNSIGNED DEFAULT NULL,
  `tokenTime` datetime DEFAULT NULL,
  `perms` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_users`
--

INSERT INTO `site_users` (`ID`, `email`, `username`, `pwd`, `encryptedkey`, `token`, `tokenTime`, `perms`) VALUES
(1, '86501@roc-teraa.nl', 'ExampleUser', '$2y$10$LmQ9bC0a7S6LdBODQDUYa.Ctvxplv1dyOwKe9.wf84Agy99cf52Mi', '0G+rGrFVY3j4BGkPFmWbIUBRx5lLiPL+8lWSwP+R7+c=', 14164858, '2022-05-13 10:20:13', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `site_favorites`
--
ALTER TABLE `site_favorites`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fav_oefening` (`ID_oefeningen`),
  ADD KEY `fav_user` (`ID_users`);

--
-- Indexes for table `site_oefeningen`
--
ALTER TABLE `site_oefeningen`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `site_schema`
--
ALTER TABLE `site_schema`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `schema_users` (`ID_users`);

--
-- Indexes for table `site_schemacontent`
--
ALTER TABLE `site_schemacontent`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `schema_id` (`ID_schema`),
  ADD KEY `schema_oefening` (`ID_oefeningen`);

--
-- Indexes for table `site_users`
--
ALTER TABLE `site_users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `site_favorites`
--
ALTER TABLE `site_favorites`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_oefeningen`
--
ALTER TABLE `site_oefeningen`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `site_schema`
--
ALTER TABLE `site_schema`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_users`
--
ALTER TABLE `site_users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Metadata for table site_oefeningen
--

--
-- Dumping data for table `pma__column_info`
--

INSERT INTO `pma__column_info` (`db_name`, `table_name`, `column_name`, `comment`, `mimetype`, `transformation`, `transformation_options`, `input_transformation`, `input_transformation_options`) VALUES
('catweb', 'site_oefeningen', 'img', '', 'text_plain', 'output/text_plain_imagelink.php', '', '', '');

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

INSERT INTO `pma__column_info` (`db_name`, `table_name`, `column_name`, `comment`, `mimetype`, `transformation`, `transformation_options`, `input_transformation`, `input_transformation_options`) VALUES
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
