-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 17 jun 2022 om 10:52
-- Serverversie: 10.4.24-MariaDB
-- PHP-versie: 7.4.29

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
-- Tabelstructuur voor tabel `site_favorites`
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
-- Gegevens worden geëxporteerd voor tabel `site_favorites`
--

REPLACE INTO `site_favorites` (`ID`, `ID_users`, `ID_oefeningen`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_link_media`
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
-- Gegevens worden geëxporteerd voor tabel `site_link_media`
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
-- Tabelstructuur voor tabel `site_link_tube`
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
-- Gegevens worden geëxporteerd voor tabel `site_link_tube`
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
-- Tabelstructuur voor tabel `site_link_workout`
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
-- Gegevens worden geëxporteerd voor tabel `site_link_workout`
--

REPLACE INTO `site_link_workout` (`ID`, `workoutID`, `oefeningID`) VALUES
(1, 1, 4),
(2, 1, 13);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_media`
--

DROP TABLE IF EXISTS `site_media`;
CREATE TABLE IF NOT EXISTS `site_media` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` varchar(145) NOT NULL,
  `width` smallint(4) DEFAULT NULL,
  `height` smallint(4) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `image_links` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `site_media`
--

REPLACE INTO `site_media` (`ID`, `link`, `width`, `height`) VALUES
(1, 'https://i.stack.imgur.com/g8eij.jpg', 350, 263),
(2, 'https://media3.popsugar-assets.com/files/2015/03/10/677/n/1922729/4dad4839_Triceps-Extensions-Red/i/Triceps-Kickback.jpg', 1500, 1500),
(3, 'https://cdn.prod.openfit.com/uploads/2018/04/A-Open_Fit_Alt_Seated_Overhead_Tricep_Ex_770.jpg', 770, 583),
(4, 'https://www.topinspired.com/wp-content/uploads/2015/01/fire-hydrant.jpg', 736, 779),
(5, 'https://annawood.co.za/wp-content/uploads/2015/07/Anna_side_plank_seq2.jpg', 4256, 2832),
(6, 'https://3i133rqau023qjc1k3txdvr1-wpengine.netdna-ssl.com/wp-content/uploads/2014/08/V-Up_Exercise.jpg', 550, 555),
(7, 'https://cdn.fitzport.com/wp-content/uploads/exercise/glutes/glute-kickback/glute-kickback-2-fitzport.com.jpg', 1280, 720),
(8, 'https://themovementfix.com/wp-content/uploads/2020/10/hip-extension-only.jpg', 1000, 607),
(9, 'https://www.strongfitnessmag.com/wp-content/uploads/2017/06/Plank-Walkout-to-Push-Up.jpg', 800, 394),
(10, 'https://cdn-ami-drupal.heartyhosting.com/sites/muscleandfitness.com/files/studio/6101/6101_B.jpg', 800, 800),
(11, 'https://www.gymguider.com/wp-content/uploads/2020/04/pike-press-up.jpg', 980, 677),
(12, 'https://www.goodfreephotos.com/albums/people/guy-doing-push-up.jpg', 6000, 4000),
(13, 'https://cdn-ami-drupal.heartyhosting.com/sites/muscleandfitness.com/files/_main_highpull.jpg', 1280, 960),
(14, 'https://i.pinimg.com/originals/91/74/00/917400b311ef474be7cefe4a1de4ba3a.jpg', 600, 600),
(15, 'https://www.crossfit.com/wp-content/uploads/2019/07/10131951/VuPKellyJackson.png', 4800, 2700);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_oefeningen`
--

DROP TABLE IF EXISTS `site_oefeningen`;
CREATE TABLE IF NOT EXISTS `site_oefeningen` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `type` enum('Kracht','Cardio') DEFAULT NULL,
  `spiergroepen` set('Triceps','Buik','Borst','Benen','Rug','Schouders','Biceps') DEFAULT NULL,
  `duration` int(10) UNSIGNED DEFAULT NULL COMMENT 'In seconden',
  `calorien` mediumint(10) UNSIGNED DEFAULT NULL,
  `loseWeight` tinyint(1) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `site_oefeningen`
--

REPLACE INTO `site_oefeningen` (`ID`, `name`, `description`, `type`, `spiergroepen`, `duration`, `calorien`, `loseWeight`) VALUES
(1, 'Schaatssprong', 'Spring vanuit een staande positie ongeveer een meter naar rechts. Land op je rechtervoet terwijl je de gebogen linkerknie recht naar voren laat wijzen. Je linkerarm beweegt langs je zij, de rechterarm omhoog met de elleboog 90 graden gebogen. Maak een hup op de plaats, en spring dan terug, land op je linkerbeen en doe dezelfde beweging terug naar de beginpositie. Dat samen is één herhaling.', 'Cardio', 'Benen', 108, NULL, NULL),
(2, 'Rugrollen', 'Begin in staande positie. Ga in één beweging op de vloer zitten en rol achterover, om je voeten richting het plafond te bewegen. Rol terug, zet je voeten dichtbij je billen plat op de grond en ga staan. Dit is één herhaling.', 'Cardio', 'Rug', 115, NULL, 1),
(3, 'Sprongburpee 180', 'Begin in een squat houding, voeten op schouderbreedte uit elkaar. Laat de heupen zakken en plaats de handpalmen op de vloer. Spring achteruit in een plankpositie en laat jezelf op de grond zakken. Doe een push-up en kom explosief omhoog. Draai tijdens de sprong een halve slag, 180 graden. Doe vervolgens een burbee aan de andere kant. Dit is één herhaling.', 'Cardio', 'Benen', 87, NULL, 1),
(4, 'Zijwaartse teen tik', 'Plaats een dumbbell, kettlebell of iets dergelijks tussen je voeten. Tik met de teen van je rechtervoet de bovenkant van het voorwerp aan, maar houd je gewicht op je linkervoet. Verplaats je gewicht snel naar je rechtervoet en raak nu met je linkervoet het voorwerp aan. Dat is één herhaling. Blijf snel wisselen terwijl je steeds met je teen licht op het voorwerp tikt.', 'Cardio', 'Benen', 115, NULL, 1),
(5, 'Weerstandsband kikkersprong', 'Ga rechtop staan, met een weerstandsband op spanning onder je knieën. De voeten staan iets verder uit elkaar dan schouderbreedte en zijn licht naar buiten gedraaid. Hurk omlaag en plaats je handen op de grond tussen je benen, terwijl je je borst en kin hoog houdt. Spring vervolgens omhoog en gooi je armen in de lucht zodat je lichaam volledig uitgestrekt is aan de top van de sprong. Breng je armen terug naar beneden terwijl je in de beginpositie landt. Dat is één herhaling.', 'Cardio', 'Benen', 121, NULL, 1),
(6, 'Aansluitpas met grondtik', 'Ga rechtop staan, met een weerstandsband op spanning onder je knieën. De voeten staan iets verder uit elkaar dan schouderbreedte en zijn licht naar buiten gedraaid. Hurk omlaag en plaats je handen op de grond tussen je benen, terwijl je je borst en kin hoog houdt. Spring vervolgens omhoog en gooi je armen in de lucht zodat je lichaam volledig uitgestrekt is aan de top van de sprong. Breng je armen terug naar beneden terwijl je in de beginpositie landt. Dat is één herhaling.', 'Cardio', 'Benen', 149, NULL, 1),
(7, 'Zittende beenkick', 'Begin in een positie op handen en voeten, de knieën iets boven de vloer. De rug is horizontaal, de schouders zijn recht boven de polsen, de knieën onder de heupen. Schop een been onder het lichaam door, langs het andere been naar voren. Til een arm op, terwijl je heup naar de grond zakt. Trek je been terug naar de beginpositie en doe hetzelfde aan de andere kant. Dat is één herhaling.', 'Cardio', 'Benen', 153, NULL, 1),
(8, 'Banksprintjes', 'Ga bij een kist of bankje staan, zet je rechtervoet er stevig bovenop en je linkervoet op de grond. Wissel snel van voet, raak de box aan met je linkervoet en keer terug naar de beginpositie. Dat is één herhaling.', 'Cardio', 'Benen', 112, NULL, 1),
(9, 'Touwtjespringen', 'Begin met de traditionele beweging. Houd de ellebogen dichtbij de ribben, maak grote cirkels met beide handen en houdt de rug mooi recht. Als dat goed gaat, kun je gaan variëren: spring vooruit en achteruit, of opzij van links naar rechts.', 'Cardio', 'Benen', 148, NULL, 1),
(10, 'Walking lunge', 'Houd een weerstandsband of springtouw met beide handen recht boven je hoofd, de armen gestrekt. Trek de schouders naar achteren (ellebogen naar buiten ​​gericht) om de rug te ondersteunen. Zak diep door de benen en stap met je linkervoet naar voren tot een diepe lunge-positie. Duw jezelf vervolgens met je linkervoet omhoog, stap met je rechtervoet naar voren en kom zo met je andere been voor in een lungepositie. Dat is één herhaling.', 'Cardio', 'Benen', 109, NULL, 1),
(11, 'Leg Raise', 'De leg raise is een bekende buikspieroefening. Het staat met name bekend vanwege de grote effectiviteit voor de onderste buikspieren. Voor een complete buikspiertraining is het zaak dat je álle buikspieren aanspreekt. Ook de onderkant mag dus niet vergeten worden. De leg raise is een van de meest effectieve oefeningen voor de onderkant buik en mag daarom zeker niet ontbreken in jouw training.', 'Kracht', 'Buik', 79, NULL, 0),
(12, 'Heel Touch', 'De heel touch is een populaire lichaamsgewicht oefening waarmee we onze obliquus abdominis (schuine buikspieren) en abdominus (rechte buikspieren) trainen. Wanneer je de heel touch op een gecontroleerde manier uitvoert zul je na een aantal herhalen merken dat je buikspieren aan de zijkanten begint te branden.', 'Kracht', 'Buik', 76, NULL, 0),
(13, 'Supermabs', 'De Superman is een omstreden, potentieel gevaarlijke oefening. Een belangrijke functie van de betrokken spieren is het strekken van de ruggenwervel en het in lijn brengen van het bovenlichaam met het onderlichaam. Dit zijn functies van de erector spinae in de rug, de bilspieren en hamstrings. Door de liggende positie zijn deze echter al in lijn. Verder doortrekken betekent dan ook dat er sprake is van hyperextensie. Er kan dan een riskante druk gevormd worden op de tussenwervelschijven.', 'Kracht', 'Buik', 112, NULL, 0),
(14, 'Bicep curl', 'De bicep curl is één van de meest bekende oefeningen om de biceps te trainen. De oefening is niet alleen effectief voor het trainen van je biceps en het opbouwen van spiermassa, het is ook nog eens makkelijk uit te voeren. ', 'Kracht', 'Biceps', 133, NULL, 0),
(15, 'Tricep dips', 'De triceps dips is een ontzettend effectieve compound oefening voor het trainen van je triceps. Deze oefening kan je in principe overal uitvoeren aangezien je amper benodigdheden nodig hebt om de oefening uit te voeren. Bovendien is het zo dat je bij deze oefening meerdere spiergroepen tegelijk traint, zo train je naast de triceps ook je schouders, borst en buikspieren. Ook leent deze oefening zich perfect voor het toepassen van Progressive Overload. Al met al een top oefening voor sterke triceps dus.', 'Kracht', 'Triceps', 131, NULL, 0),
(16, 'Schouder raise', 'Bij het uitvoeren van de schoulder raise train je vooral het voor- en middelste deel van de schouder spieren (deltoids). Je zal merken dat dit relatief kleine spiergroepen zijn en dat je snel verzuurt. Maar deze oefening geeft de totale schouderpartij wel meer vulling, dus onmisbaar voor mensen die brede schouders willen.', 'Kracht', 'Schouders', 137, NULL, 0),
(17, 'Push-up', 'De push-up is een geschikte trainingsmethode voor het ontwikkelen van kracht in de romp en borst. Je traint namelijk vooral spieren in de borst, armen en schouders. Ook de buikspieren, spieren in de onderrug en beenspieren werken mee. Deze oefening kan op de vloer worden uitgevoerd en geeft met een fitnessmat iets meer comfort. Kortom: je kunt deze oefening overal uitvoeren en het geeft uitdaging aan praktisch je hele lichaam.', 'Kracht', 'Borst', 100, NULL, 0),
(18, 'Squads', 'Een squat oefening is een kniebuiging, optioneel met een gewicht op je schouders of in je handen om de oefening extra zwaar te maken. De beweging is vergelijkbaar met gaan zitten en direct weer omhoog komen. De oefening is eenvoudig en zeer geschikt voor beginnende sporters, maar moet wel op de juiste manier uitgevoerd worden. Je traint tijdens de squat met name je bovenbeenspieren en bilspieren, oftewel je hamstrings en quadriceps. Ook je kuitspieren en core spieren (= spieren rondom je romp) worden geactiveerd tijdens het uitvoeren van een squat. ‘Squat’ is een Engelstalige term die wereldwijd binnen de krachtsport wordt gebruikt om de ‘kniebuiging’ fitnessoefening aan te duiden. De betekenis van squat is letterlijk hurken.', 'Kracht', 'Benen', 117, NULL, 0),
(19, 'Lunges', 'Lunges of de lunge betekent letterlijk ‘uitvallen’. Daarmee doelt het woord op de positie van het lichaam waarbij één been naar voren is geplaatst met de knie gebogen en de voet plat op de grond, terwijl het andere been erachter wordt geplaatst.', 'Kracht', 'Benen', 132, NULL, 0),
(20, 'Plank', 'Planken is misschien één van de minst indrukwekkend uitziende oefeningen die je ooit zult tegenkomen.\r\n\r\nAls je niet zou weten wat het is, zou je denken dat iemand aan het uitrusten is of op een zeer onhandige manier zijn contactlenzen op de grond zoekt.\r\n\r\nPlanken is op verschillende manieren uit te voeren. Maar de bekendste uitvoering is langgerekt steunen op je ellebogen en tenen.\r\nHierbij is het de bedoeling dat jij je stevig aanspant om te voorkomen dat je lichaam in elkaar zakt.\r\n\r\nSommige mensen zullen vanaf de eerst seconden moeite hebben met deze houding houden en anderen zullen pas tientallen tellen moeten doorstaan voordat ze iets voelen branden. Het verschil tussen individuen is vooral te verklaren door verschil in gewicht en kracht van de core (romp spieren).', 'Kracht', 'Buik', 148, NULL, 0),
(21, 'Face pull', 'De face pull is een oefening voor de achterkant van de schouders. We zien deze oefening als een ondergeschoven kindje. Naar onze mening krijgen face pulls dan ook niet de aandacht die het verdiend. Op deze pagina vind je een complete uitleg over deze oefening. We leggen je uit hoe je de perfecte face pulls kunt maken en waar je op moet letten.', 'Kracht', 'Schouders', 110, NULL, 0),
(22, 'Incline curl', 'Ga op een trainingsbankje zitten en pak in elke hand een dumbbell. Til vervolgens de dumbbells één voor één met de handpalmen omhoog, naar je schouders toe (dus eerst je ene arm en dan je andere arm). Laat vervolgens de dubbells weer langzaam zakken. Het is belangrijk om je bovenarmen in een rechte lijn naar je toe te halen en niet te laten ‘slingeren’, zodat je de biceps optimaal traint. Met deze oefening train je voornamelijk de lange kop.', 'Kracht', 'Biceps', 129, NULL, 0),
(23, 'Hammer curl', 'Pak de dumbbells vast, ga met je voeten op schouderbreedte van elkaar staan en buig je knieën lichtelijk. Zorg dat je handpalmen naar je lichaam toe zijn gericht als je de dumbbells vast hebt. Houd vervolgens je ellebogen dicht bij je lichaam en breng de dumbbell langzaam tot je schouders. Laat volgens de dumbbells weer langzaam zakken. Met deze oefening train je voornamelijk de korte kop.', 'Kracht', 'Biceps', 141, NULL, 0),
(24, 'Standing curl', 'Ga met je voeten op schouderbreedte van elkaar staan met je knieën licht gebogen. Houd in beide handen een dumbbell vast met je polsen omhoog. Breng de dumbbells vervolgens naar je schouders toe, waarbij je je ellebogen naar binnen houdt. Laat vervolgens de dumbbells weer langzaam zakken. Het is belangrijk om je bovenarmen niet te laten slingeren, zodat je de biceps optimaal traint. Met deze oefening train je voornamelijk de lange kop.', 'Kracht', 'Biceps', 157, NULL, 0),
(25, 'Concentration curl', 'Ga op een plat bankje zitten en pak een dumbbell vast. Buig je rug naar voren en plaats je elleboog op je bovenbeen (richting je knie). Plaats vervolgens je vrije hand op de andere knie om jezelf te stabiliseren. Breng vervolgens de dumbbell richting je schouder. Laat nu de dumbbell weer langzaam zakken. Met deze oefening train je voornamelijk de lange kop.', 'Kracht', 'Biceps', 84, NULL, 0),
(26, 'Bar & Rope pushdown', 'Houd je onderrug recht en je core aangespannen. Neem de bar vast met een wijde greep met je ellebogen in een hoek van 90 graden. Duw de bar naar beneden tot aan je heupen. Ditzelfde kun je ook doen met een triceps touw in plaats van een bar. Dan train je voornamelijk de mediale kop.', 'Kracht', 'Triceps', 114, NULL, 0),
(27, 'Overhead rope extension', 'Ga voor het kabelstation staan pak de kabels vast. Breng de kabels boven je hoofd en strek je armen. Houd je hele lichaam stil en buig je ellebogen langzaam. Laat je handen achter je hoofd zakken totdat je ellebogen net onder de 90 graden zijn. Let erop dat je ellebogen naar voren blijven wijzen en niet naar de zijkant.', 'Kracht', 'Triceps', 145, NULL, 0),
(28, 'Weighted tricep dips', 'Doe een riem om, bevestig de halterschijf aan en touw en maak deze vast aan je riem. Neem vervolgens de diphouding aan bij het dipstation of power tower. Terwijl je dipt, laat je je ellebogen zo min mogelijk naar buiten wijzen. Als beginner kun je deze triceps oefening zonder gewichten uitvoeren.', 'Kracht', 'Triceps', 147, NULL, 0),
(29, 'Diamond push', 'Neem een plankhouding aan en plaats je handen onder je borst. Zorg ervoor dat je wijsvingers en duimen elkaar zo raken dat ze een ruitvorm vormen. Voer nu een push up beweging uit, waarbij je erop let dat je ellebogen zo strak mogelijk langs je lichaam blijven. Deze triceps oefening zonder gewichten kun je zwaarder maken door meer herhalingen sneller achter elkaar uit te voeren.', 'Kracht', 'Triceps', 155, NULL, 0),
(30, 'Reverse fly cable', 'Bevestig een Single grip kabelaccessoire aan beide kabels van de Cable crossover en pak deze vast. Zorg dat je je armen recht vooruit houdt met licht gebogen ellebogen. Houd je armen op schouderbreedte en buig je knieën lichtelijk. Trek de handgrepen zijdelings naar achter en zorg ervoor dat je ellebogen licht gebogen blijven. Laat vervolgens de handgrepen weer langzaam zakken naar de uitgangspositie.', 'Kracht', 'Schouders', 115, NULL, 0),
(31, 'Seated overhead dumbell press', 'De Seated Overhead Dumbbell Press is vergelijkbaar met de Seated Overhead Barbell Press. Pak in beide handen een dumbbell en ga op een trainingsbankje zitten. Houd de dumbbells op schouderbreedte en span je buik aan voor een stabiele houding. Druk de dumbbells tot boven je hoofd. Laat nu de dumbbells weer langzaam zakken tot de uitgangspositie. Zorg ervoor dat de dumbbells op een verticale lijn van boven naar beneden bewegen.', 'Kracht', 'Schouders', 90, NULL, 0),
(32, 'Lateral raise', 'Pak in beide handen een dumbbell en houd je armen langs je lichaam met je polsen naar je toe gericht. Zorg ervoor dat je schouders recht zijn (niet te ontspannen en niet omhoog getrokken), span je buikspieren aan en buig je knieën lichtelijk. Dit zorgt voor een stabiele houding. Til vervolgens de dumbbells met rechte armen zijwaarts omhoog tot schouderhoogte. Laat dan de dumbbells geleidelijk aan weer zakken naar de uitgangspositie.', 'Kracht', 'Schouders', 120, NULL, 0),
(33, 'Schuine crunch', 'Ga op je rug liggen en plaats je handen bij je oren met je ellebogen naar binnen wijzend. Breng nu je linkerschouder iets van de grond, waardoor je elleboog naar binnen draait. Til tegelijkertijd je rechterknie omhoog richting je linkerelleboog. Herhaal deze oefening met je rechterschouder. Als je dit snel genoeg doet, lijkt het op een fietsbeweging met je benen.', 'Kracht', 'Buik', 155, NULL, 0),
(34, 'Ab roller', 'Ga op je knieën zitten en houd de handvaten van de Ab-Roller vast. Maak langzaam een korte voorwaartse beweging, hoe verder naar voren, hoe beter. Houd bij het terugrollen spanning op de buikspieren en ga dus niet helemaal terug in ruststand. Voer de beweging gecontroleerd uit. Als beginner kan het fijn zijn om hier een trainingsmaatje bij te hebben, die controleert of je een goede houding aanneemt. Is het te makkelijk op je knieën? Ga dan op je tenen.', 'Kracht', 'Buik', 142, NULL, 0),
(35, 'Bankdrukken', 'Ben je op zoek naar barbell oefeneningen dan is bankdrukken zeker geschikt. Met bankdrukken kun je de meeste kracht genereren; met bankdrukken kun je daarom ook het meeste gewicht aan, waardoor je relatief de meeste spiermassa kunt opbouwen. Daarnaast is het eenvoudiger om een barbell onder controle te houden, dan bijvoorbeeld twee zware dumbbells tijdens dumbbell press. Daarmee is deze oefening vooral geschikt voor de relatief onervaren krachtsporter. Je kunt deze oefening al uitvoeren met een enkele barbell met gewichtsschijven en een halterbank!', 'Kracht', 'Borst', 160, NULL, 0),
(36, 'Cable crossover flyes', 'Deze lijst bevat niet veel isolatie oefeningen voor het trainen van je borstspieren, maar dit is een favoriet van de kabel oefeningen. De cables zorgen bij cable crossover oefeningen ervoor dat je borstspieren gedurende de hele beweging aangespannen blijven. Voor een optimaal effect voer je deze borstspieroefening uit op een schuine fitnessbank.', 'Kracht', 'Borst', 140, NULL, 0),
(37, 'Pc fly machine ', 'Chest flyes zijn voor veel beginners moeilijk om te leren met dumbbells en/of cables. De Pec Fly maakt de oefening een stuk eenvoudiger, doordat de machine je tijdens de oefening in de goede richting begeleidt. Uiteindelijk zul je deze oefening ook makkelijker met dumbbells uit kunnen voeren.', 'Kracht', 'Borst', 145, NULL, 0),
(38, 'Barbell deadlift', 'De barbell deadlift is de absolute koning wanneer we het hebben over compound oefeningen. Het is een ‘full-body’ oefeningen waarbij je spieren in het hele lichaam gebruikt om het gewicht van de grond te tillen. De deadlift is de meest geschikte oefeningen om de spiervezels in de onderrug te versterken. Daarnaast plaats je spanning op alle spieren in de bovenrug. Doordat alle spieren in de rug betrokken zijn bij het uitvoeren van de deadlift, is het de absolute nummer 1 oefeningen in elke rug workout.', 'Kracht', 'Rug', 134, NULL, 0),
(39, 'Pull up', 'Wanneer je een V-vorm in je rugspieren wil, dan ontkom je niet aan het implementeren van de pull up in je rug workouts. Met de pull up belast je de lat-spieren direct. Dit zijn de spieren die de rug breder maken. De pull up is een zware oefeningen en is daardoor niet door iedereen uit te voeren. Wanneer de pull up met je eigen lichaamsgewicht te zwaar is, betekent dat niet dat je de oefening in zijn geheel linkt hoeft laten te liggen. Veel sportscholen hebben namelijk een assisted pull up/dip machine. Daarnaast kan je gewoon iemand vragen je bij de enkels naar boven te duwen tijdens de oefening.', 'Kracht', 'Rug', 98, NULL, 0),
(40, 'Lat pulldown', 'Net zoals de pull up – een absolute bodybuilding favoriet – is de pull down een zeer effectieve oefeningen om de lat spieren te trainen. Vaak zien we ook varianten voorbij komen waarbij de stang achter de nek wordt getrokken. Je bent beter af om de stang naar de bovenkant van de borst te brengen. Wanneer je een achter de nek variant doet loop je een risico op schouderblessures.', 'Kracht', 'Rug', 120, NULL, 0),
(41, 'Cable seated row', 'De cable seated row is ook een geschikte oefening om spiergroepen in de hele rug effectief te trainen. Wanneer je de focus op de lats wil leggen, gebruik dan een stang met een smalle grip (handen dicht bij elkaar). Wil je de focus leggen op de rhomboideus, gebruik dan een lat pull down stang waar je een brede grip kan gebruiken.', 'Kracht', 'Rug', 111, NULL, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_schema`
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
-- Tabelstructuur voor tabel `site_schemacontent`
--

DROP TABLE IF EXISTS `site_schemacontent`;
CREATE TABLE IF NOT EXISTS `site_schemacontent` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ID_schema` int(10) UNSIGNED NOT NULL,
  `ID_oefeningen` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `schema_id` (`ID_schema`),
  KEY `schema_oefening` (`ID_oefeningen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_tube`
--

DROP TABLE IF EXISTS `site_tube`;
CREATE TABLE IF NOT EXISTS `site_tube` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` varchar(15) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `tube_links` (`link`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `site_tube`
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
-- Tabelstructuur voor tabel `site_users`
--

DROP TABLE IF EXISTS `site_users`;
CREATE TABLE IF NOT EXISTS `site_users` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL COMMENT 'Regex validation from: https://www.rhyous.com/2010/06/15/csharp-email-regular-expression',
  `username` varchar(100) DEFAULT NULL,
  `pwd` char(60) NOT NULL,
  `encryptedkey` varchar(120) NOT NULL,
  `token` mediumint(8) UNSIGNED DEFAULT NULL,
  `tokenTime` datetime DEFAULT NULL,
  `perms` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `FirstName` varchar(30) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `usernames` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `site_users`
--

REPLACE INTO `site_users` (`ID`, `email`, `username`, `pwd`, `encryptedkey`, `token`, `tokenTime`, `perms`, `FirstName`, `LastName`) VALUES
(1, '86501@roc-teraa.nl', 'ExampleUser', '$2y$10$LmQ9bC0a7S6LdBODQDUYa.Ctvxplv1dyOwKe9.wf84Agy99cf52Mi', '0G+rGrFVY3j4BGkPFmWbIUBRx5lLiPL+8lWSwP+R7+c=', NULL, NULL, 1, '', ''),
(2, 'jurienbraat2002@gmail.com', 'Deadvire', '$2y$10$QVDivmLX53f2dW4HvA4EqeO62hvYuUC64oZZ1c3OtBMYib6UzkZyS', 'NQd636GWtEfkS/M0EWe+Ul42F2K3JTbwgyFiAZ9AjpP6richgSdbSI0XRuCsJTJ54+vVMlRkeSmciHvTEz0oHg==', NULL, NULL, 0, '', ''),
(3, 'MelanieHoogenboom44@gmail.com', 'MelanieTheSquad', '$2y$10$Fwnlsalij.MoCbNapgNr5edNt0ftmjCLNaHUvLxAQ5u6G3ZHXv61m', 'EoQlge5znGe+EW4oVNGKr13QIjmWK2lZcp6BF9WTxCVXCMeEA1vfULfKifHIp4pJfqZG9ss1ksYRoiTat1KnVA==', NULL, NULL, 0, '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `site_workout`
--

DROP TABLE IF EXISTS `site_workout`;
CREATE TABLE IF NOT EXISTS `site_workout` (
  `workoutID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `workTitle` varchar(30) NOT NULL,
  `Beschrijving` text NOT NULL,
  PRIMARY KEY (`workoutID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `site_workout`
--

REPLACE INTO `site_workout` (`workoutID`, `workTitle`, `Beschrijving`) VALUES
(1, 'Cardio', 'Hier is een tekst om in te vullen waarbij cardio als deze workout hoofddoel wordt gebruikt'),
(2, 'Kracht', 'Hier is een tekst om in te vullen waarbij kracht als deze workout hoofddoel wordt gebruikt');

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
-- Beperkingen voor tabel `site_link_media`
--
ALTER TABLE `site_link_media`
  ADD CONSTRAINT `media_link` FOREIGN KEY (`mediaID`) REFERENCES `site_media` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `oefening_media_link` FOREIGN KEY (`oefeningenID`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `site_link_tube`
--
ALTER TABLE `site_link_tube`
  ADD CONSTRAINT `oefening_tube_link` FOREIGN KEY (`oefeningenID`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tube_link` FOREIGN KEY (`mediaID`) REFERENCES `site_tube` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `site_link_workout`
--
ALTER TABLE `site_link_workout`
  ADD CONSTRAINT `Oefening ID` FOREIGN KEY (`oefeningID`) REFERENCES `site_oefeningen` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Workout ID` FOREIGN KEY (`workoutID`) REFERENCES `site_workout` (`workoutID`) ON DELETE CASCADE ON UPDATE CASCADE;

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


--
-- Metadata
--
USE `phpmyadmin`;

--
-- Metadata voor tabel site_favorites
--

--
-- Metadata voor tabel site_link_media
--

--
-- Metadata voor tabel site_link_tube
--

--
-- Metadata voor tabel site_link_workout
--

--
-- Metadata voor tabel site_media
--

--
-- Gegevens worden geëxporteerd voor tabel `pma__column_info`
--

REPLACE INTO `pma__column_info` (`db_name`, `table_name`, `column_name`, `comment`, `mimetype`, `transformation`, `transformation_options`, `input_transformation`, `input_transformation_options`) VALUES
('catweb', 'site_media', 'link', '', 'text_plain', 'output/text_plain_imagelink.php', '', '', '');

--
-- Metadata voor tabel site_oefeningen
--

--
-- Metadata voor tabel site_schema
--

--
-- Metadata voor tabel site_schemacontent
--

--
-- Metadata voor tabel site_tube
--

--
-- Gegevens worden geëxporteerd voor tabel `pma__column_info`
--

REPLACE INTO `pma__column_info` (`db_name`, `table_name`, `column_name`, `comment`, `mimetype`, `transformation`, `transformation_options`, `input_transformation`, `input_transformation_options`) VALUES
('catweb', 'site_tube', 'link', '', 'text_plain', 'text_plain_link.php', '\'https://youtu.be/\'', '', '');

--
-- Metadata voor tabel site_users
--

--
-- Gegevens worden geëxporteerd voor tabel `pma__column_info`
--

REPLACE INTO `pma__column_info` (`db_name`, `table_name`, `column_name`, `comment`, `mimetype`, `transformation`, `transformation_options`, `input_transformation`, `input_transformation_options`) VALUES
('catweb', 'site_users', 'email', '', 'text_plain', '', '', 'Input/Text_Plain_RegexValidation.php', '\'/^[\\\\w!#$%&\\\\\\\'*+\\\\-\\\\/=?^_`{|}~]+(\\\\.[\\\\w!#$%&\\\\\\\'*+\\\\-\\\\/=?^_`{|}~]+)*@((([\\\\-\\\\w]+\\\\.)+[a-zA-Z]{2,4})|(([0-9]{1,3}\\\\.){3}[0-9]{1,3}))$/\''),
('catweb', 'site_users', 'perms', '', '', 'output/text_plain_bool2text.php', '', '', ''),
('catweb', 'site_users', 'tokenTime', '', 'text_plain', 'output/text_plain_dateformat.php', '', '', '');

--
-- Metadata voor tabel site_workout
--

--
-- Metadata voor database catweb
--
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
