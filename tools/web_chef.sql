-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2020 at 11:52 PM
-- Server version: 10.3.25-MariaDB-0+deb10u1
-- PHP Version: 7.3.19-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_chef`
--

-- --------------------------------------------------------

--
-- Table structure for table `tIngredients`
--

CREATE TABLE `tIngredients` (
  `I_ID` int(11) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tIngredients`
--

INSERT INTO `tIngredients` (`I_ID`, `name`) VALUES
(0, 'Mahl'),
(1, 'Zucker'),
(2, 'Wasser'),
(3, 'Speisestärke'),
(4, 'Sahne'),
(5, 'Sauerkirschen'),
(6, 'Kakaopulver'),
(7, 'Backpulver'),
(8, 'Sahnesteif'),
(9, 'Eier'),
(10, 'Kirschwasser'),
(11, 'Schokoladenraspel'),
(12, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tMeal`
--

CREATE TABLE `tMeal` (
  `M_ID` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `preparation_text` text NOT NULL,
  `preparation_time` int(11) NOT NULL,
  `img` varchar(225) DEFAULT NULL,
  `MT_ID` int(11) NOT NULL,
  `U_ID` int(11) NOT NULL,
  `is_public` tinyint(1) NOT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `description` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tMeal`
--

INSERT INTO `tMeal` (`M_ID`, `name`, `preparation_text`, `preparation_time`, `img`, `MT_ID`, `U_ID`, `is_public`, `creation_date`, `description`) VALUES
(0, 'Schwarzwälder Kirschtorte', 'Eigelb mit Wasser und Zucker so lange rühren, bis eine sehr cremige Masse entstanden ist und die Zuckerkristalle nicht mehr sichtbar sind.<br>Mehl, Stärke, Backpulver und Kakao mischen und auf die Eigelbcreme sieben. Eiweiß steif schlagen und alles vorsichtig unterheben. Sofort in eine gefettete, bemehlte Springform füllen und bei 200 °C 30 – 35 min ausbacken. Dabei die Temperatur im Backverlauf senken, damit der Biskuit nicht einsinkt, so dass die Temperatur zum Ende der Backzeit nur noch ca. 150°C beträgt. Auskühlen lassen.<br><br>Die Sauerkirschen über einer Schüssel abgießen, so dass der Saft aufgefangen wird. Die Stärke mit etwas von dem kalten Kirschsaft anrühren. Den restlichen Kirschsaft aufkochen und die angerührte Speisestärke einrühren. Unter Rühren einmal aufkochen lassen, dann gleich vom Herd nehmen. Brennt schnell an! Die 16 schönsten Kirschen beiseitelegen. Den Rest unter den Kirschsaftmasse heben. <br><br>Den Tortenboden zweimal durchschneiden; den untersten mit etwas Kirschwasser beträufeln, mit der Kirschmasse überziehen. Auskühlen lassen. <br><br>Die Sahne mit dem Sahnesteif und Zucker steif schlagen , dünn auf die ausgekühlten Kirschmasse streichen, nächsten Tortenboden auflegen und leicht andrücken. Wieder mit Kirschwasser beträufeln.<br><br>Den Boden mit ca. ½ der Sahne bestreichen, nächsten Boden aufdrücken. Von der restlichen Sahne etwa 3 EL in einen Spritzbeutel füllen. Die Torte mit der restlichen Sahne rundherum verkleiden, mit dem Spritzbeutel 16 Tuffs aufspritzen und mit den beiseite gelegten Kirschen belegen. Oberfläche und Rand mit Raspelschokolade bestreuen. <br><br>Toll sieht die Torte auch in einer Herzform aus! ', 95, 'res/uploads/MbgYVeTiikOeOmmxxW84.jpeg', 3, 0, 1, '2020-12-09', 'Die klassische Torte die auf der ganzen Welt bekannt ist.<br>Sahnetorte mit Schokoladenbiskuitboden und Kirschen.'),
(1, 'Rezept Name:', '...', 1, 'res/uploads/ZJrthBkLCqQgzraWK7fG.jpeg', 0, 0, 1, '2020-12-13', 'Kurze beschreibung des Rezepts:');

-- --------------------------------------------------------

--
-- Table structure for table `tMealType`
--

CREATE TABLE `tMealType` (
  `MT_ID` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tMealType`
--

INSERT INTO `tMealType` (`MT_ID`, `name`) VALUES
(0, 'Hauptgericht'),
(1, 'Vorspeise'),
(2, 'Dessert'),
(3, 'Backen'),
(4, 'Anderes');

-- --------------------------------------------------------

--
-- Table structure for table `tRecipeMeta`
--

CREATE TABLE `tRecipeMeta` (
  `M_ID` int(11) NOT NULL,
  `U_ID` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tRecipes`
--

CREATE TABLE `tRecipes` (
  `M_ID` int(11) NOT NULL,
  `I_ID` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `UN_ID` int(11) NOT NULL,
  `meal_nr` smallint(6) NOT NULL,
  `name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tRecipes`
--

INSERT INTO `tRecipes` (`M_ID`, `I_ID`, `quantity`, `UN_ID`, `meal_nr`, `name`) VALUES
(0, 0, 200, 1, 1, 'das Rezept'),
(0, 1, 250, 1, 1, 'das Rezept'),
(0, 2, 6, 5, 1, 'das Rezept'),
(0, 3, 100, 1, 1, 'das Rezept'),
(0, 4, 800, 1, 1, 'das Rezept'),
(0, 5, 1, 6, 1, 'das Rezept'),
(0, 6, 50, 1, 1, 'das Rezept'),
(0, 7, 2, 4, 1, 'das Rezept'),
(0, 8, 1, 6, 1, 'das Rezept'),
(0, 9, 6, 6, 1, 'das Rezept'),
(0, 10, 1, 6, 1, 'das Rezept'),
(0, 11, 1, 6, 1, 'das Rezept'),
(1, 12, 1, 0, 1, 'das Rezept'),
(1, 12, 1, 0, 1, 'das Rezept');

-- --------------------------------------------------------

--
-- Table structure for table `tUnit`
--

CREATE TABLE `tUnit` (
  `UN_ID` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `long_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tUnit`
--

INSERT INTO `tUnit` (`UN_ID`, `name`, `long_name`) VALUES
(0, 'kg', 'Kilogramm'),
(1, 'g', 'Gramm'),
(2, 'l', 'Liter'),
(3, 'ml', 'Milliliter'),
(4, 'tl', 'Teelöffel'),
(5, 'el', 'Esslöffel'),
(6, 'Tasse(n)', 'Tasse'),
(7, 'st', 'Stück'),
(8, 'Etwas', 'Etwas');

-- --------------------------------------------------------

--
-- Table structure for table `tUser`
--

CREATE TABLE `tUser` (
  `U_ID` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `creation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tIngredients`
--
ALTER TABLE `tIngredients`
  ADD PRIMARY KEY (`I_ID`);

--
-- Indexes for table `tMeal`
--
ALTER TABLE `tMeal`
  ADD PRIMARY KEY (`M_ID`);

--
-- Indexes for table `tMealType`
--
ALTER TABLE `tMealType`
  ADD PRIMARY KEY (`MT_ID`);

--
-- Indexes for table `tUnit`
--
ALTER TABLE `tUnit`
  ADD PRIMARY KEY (`UN_ID`);

--
-- Indexes for table `tUser`
--
ALTER TABLE `tUser`
  ADD PRIMARY KEY (`U_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
