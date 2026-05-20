-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 12, 2026 at 08:14 AM
-- Server version: 8.0.44
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet`
--

-- --------------------------------------------------------

--
-- Table structure for table `ARTICLE`
--

CREATE TABLE `ARTICLE` (
  `ID_article` int NOT NULL,
  `Titre` varchar(255) NOT NULL,
  `Contenu` text NOT NULL,
  `Note` decimal(3,1) DEFAULT NULL,
  `Date_publ` datetime DEFAULT CURRENT_TIMESTAMP,
  `Date_modif` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ID_jeu` int DEFAULT NULL,
  `ID_member` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ARTICLE`
--

INSERT INTO `ARTICLE` (`ID_article`, `Titre`, `Contenu`, `Note`, `Date_publ`, `Date_modif`, `ID_jeu`, `ID_member`) VALUES
(1, 'Le chef d oeuvre de FromSoftware', 'Critique détaillée du jeu...', 9.5, '2026-05-12 10:10:29', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `AVIS`
--

CREATE TABLE `AVIS` (
  `ID_avis` int NOT NULL,
  `Titre` varchar(255) DEFAULT NULL,
  `Texte` text,
  `Note` int DEFAULT NULL,
  `Date_crea` datetime DEFAULT CURRENT_TIMESTAMP,
  `ID_member` int DEFAULT NULL,
  `ID_jeu` int DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `CLASSER`
--

CREATE TABLE `CLASSER` (
  `ID_jeu` int NOT NULL,
  `ID_genre` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `CLASSER`
--

INSERT INTO `CLASSER` (`ID_jeu`, `ID_genre`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `GENRE`
--

CREATE TABLE `GENRE` (
  `ID_genre` int NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `GENRE`
--

INSERT INTO `GENRE` (`ID_genre`, `nom`) VALUES
(1, 'Horreur'),
(2, 'Action'),
(3, 'Adventure'),
(4, 'Puzzle');

-- --------------------------------------------------------

--
-- Table structure for table `JEU`
--

CREATE TABLE `JEU` (
  `ID_jeu` int NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Prix` decimal(5,2) DEFAULT NULL,
  `Date_sortie` date DEFAULT NULL,
  `Synopsis` text,
  `Image_tt` varchar(255) NOT NULL,
  `ID_support` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `JEU`
--

INSERT INTO `JEU` (`ID_jeu`, `Nom`, `Prix`, `Date_sortie`, `Synopsis`, `Image_tt`, `ID_support`) VALUES
(1, 'Elden Ring', 59.99, '2022-02-25', 'Un grand RPG en monde ouvert...', 'images/elden_ring_jaquette.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `MEMBRE`
--

CREATE TABLE `MEMBRE` (
  `ID_member` int NOT NULL,
  `Nom` varchar(100) NOT NULL,
  `Prenom` varchar(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Mdp` varchar(255) NOT NULL,
  `Mail` varchar(100) NOT NULL,
  `Perm` varchar(20) NOT NULL,
  `Date_naiss` date NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `Date_dern_conex` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `MEMBRE`
--

INSERT INTO `MEMBRE` (`ID_member`, `Nom`, `Prenom`, `Username`, `Mdp`, `Mail`, `Perm`, `Date_naiss`, `Photo`, `Date_creation`, `Date_dern_conex`) VALUES
(1, 'Collet', 'Karl', 'Karl_Collet1', 'Collet.1', 'karlcollet@gmail.fr', 'administrateur', '2006-11-26', NULL, '2026-05-12 10:08:43', NULL),
(2, 'Mumladze', 'Ani', 'Ani_Mumladze2', 'Mumladze.2', 'animumladze@gmail.com', 'membre', '2006-02-24', NULL, '2026-05-12 10:08:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `PHOTOS`
--

CREATE TABLE `PHOTOS` (
  `ID_photo` int NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `ID_jeu` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SUPPORT`
--

CREATE TABLE `SUPPORT` (
  `ID_support` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `logo` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `SUPPORT`
--

INSERT INTO `SUPPORT` (`ID_support`, `nom`, `logo`) VALUES
(1, 'PS5', NULL),
(2, 'Switch', NULL),
(3, 'PC', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ARTICLE`
--
ALTER TABLE `ARTICLE`
  ADD PRIMARY KEY (`ID_article`),
  ADD UNIQUE KEY `ID_jeu` (`ID_jeu`),
  ADD KEY `ID_member` (`ID_member`);

--
-- Indexes for table `AVIS`
--
ALTER TABLE `AVIS`
  ADD PRIMARY KEY (`ID_avis`),
  ADD UNIQUE KEY `ID_member` (`ID_member`,`ID_jeu`),
  ADD KEY `ID_jeu` (`ID_jeu`);

--
-- Indexes for table `CLASSER`
--
ALTER TABLE `CLASSER`
  ADD PRIMARY KEY (`ID_jeu`,`ID_genre`),
  ADD KEY `ID_genre` (`ID_genre`);

--
-- Indexes for table `GENRE`
--
ALTER TABLE `GENRE`
  ADD PRIMARY KEY (`ID_genre`);

--
-- Indexes for table `JEU`
--
ALTER TABLE `JEU`
  ADD PRIMARY KEY (`ID_jeu`),
  ADD KEY `ID_support` (`ID_support`);

--
-- Indexes for table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  ADD PRIMARY KEY (`ID_member`),
  ADD UNIQUE KEY `uc_username` (`Username`);

--
-- Indexes for table `PHOTOS`
--
ALTER TABLE `PHOTOS`
  ADD PRIMARY KEY (`ID_photo`),
  ADD KEY `ID_jeu` (`ID_jeu`);

--
-- Indexes for table `SUPPORT`
--
ALTER TABLE `SUPPORT`
  ADD PRIMARY KEY (`ID_support`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ARTICLE`
--
ALTER TABLE `ARTICLE`
  MODIFY `ID_article` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `AVIS`
--
ALTER TABLE `AVIS`
  MODIFY `ID_avis` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `JEU`
--
ALTER TABLE `JEU`
  MODIFY `ID_jeu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `MEMBRE`
--
ALTER TABLE `MEMBRE`
  MODIFY `ID_member` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `PHOTOS`
--
ALTER TABLE `PHOTOS`
  MODIFY `ID_photo` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ARTICLE`
--
ALTER TABLE `ARTICLE`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`ID_jeu`) REFERENCES `JEU` (`ID_jeu`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`ID_member`) REFERENCES `MEMBRE` (`ID_member`);

--
-- Constraints for table `AVIS`
--
ALTER TABLE `AVIS`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`ID_member`) REFERENCES `MEMBRE` (`ID_member`) ON DELETE CASCADE,
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`ID_jeu`) REFERENCES `JEU` (`ID_jeu`) ON DELETE CASCADE;

--
-- Constraints for table `CLASSER`
--
ALTER TABLE `CLASSER`
  ADD CONSTRAINT `classer_ibfk_1` FOREIGN KEY (`ID_jeu`) REFERENCES `JEU` (`ID_jeu`) ON DELETE CASCADE,
  ADD CONSTRAINT `classer_ibfk_2` FOREIGN KEY (`ID_genre`) REFERENCES `GENRE` (`ID_genre`) ON DELETE CASCADE;

--
-- Constraints for table `JEU`
--
ALTER TABLE `JEU`
  ADD CONSTRAINT `jeu_ibfk_1` FOREIGN KEY (`ID_support`) REFERENCES `SUPPORT` (`ID_support`);

--
-- Constraints for table `PHOTOS`
--
ALTER TABLE `PHOTOS`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`ID_jeu`) REFERENCES `JEU` (`ID_jeu`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
