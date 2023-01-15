-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 15 jan. 2023 à 19:21
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `memory`
--

-- --------------------------------------------------------

--
-- Structure de la table `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` text NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `players`
--

INSERT INTO `players` (`id`, `login`, `password`) VALUES
(33, 'admin', '$2y$10$fwI63Y4buB5U71zgclQFvuF9C9Fa41dQTsKz9NEeQkx7phSO4a/6W'),
(35, 'titi', '$2y$10$.Qg/hCxReJCDXEEkKd0DLe4a2RpYtv/6b56y53koc8iM2AnVXwOFW'),
(36, 'mine', '$2y$10$N0ciMfJYcNoC2t0fnfiZMeltDAS82lu6y52x4dAUguWrjKjfjMfzK');

-- --------------------------------------------------------

--
-- Structure de la table `player_score`
--

DROP TABLE IF EXISTS `player_score`;
CREATE TABLE IF NOT EXISTS `player_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `coups` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `player_id` (`player_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `player_score`
--

INSERT INTO `player_score` (`id`, `player_id`, `coups`, `level`) VALUES
(34, 36, 5, 3),
(33, 36, 5, 3),
(4, 33, 32, 12),
(5, 33, 32, 12),
(6, 33, 32, 12),
(7, 33, 32, 12),
(8, 33, 32, 12),
(9, 33, 32, 12),
(10, 33, 32, 12),
(11, 33, 32, 12),
(12, 33, 32, 12),
(13, 33, 32, 12),
(14, 33, 32, 12),
(15, 33, 32, 12),
(16, 33, 32, 12),
(17, 33, 32, 12),
(18, 33, 32, 12),
(19, 33, 6, 3),
(20, 33, 6, 3),
(21, 33, 6, 3),
(22, 33, 6, 3),
(23, 33, 6, 3),
(24, 33, 6, 3),
(25, 33, 6, 4),
(26, 33, 6, 4),
(27, 33, 5, 3),
(28, 33, 47, 12),
(29, 33, 31, 12),
(30, 33, 37, 12),
(31, 33, 40, 12),
(32, 33, 8, 4),
(35, 36, 5, 3),
(36, 36, 5, 3),
(37, 36, 5, 3),
(38, 36, 5, 3),
(39, 36, 5, 3),
(40, 36, 6, 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
