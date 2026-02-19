-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 19 fév. 2026 à 10:10
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bibliotheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

DROP TABLE IF EXISTS `emprunts`;
CREATE TABLE IF NOT EXISTS `emprunts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `livre_id` int NOT NULL,
  `membre_id` int NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour_prevue` date NOT NULL,
  `date_retour_effective` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `livre_id` (`livre_id`),
  KEY `membre_id` (`membre_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=geostd8;

--
-- Déchargement des données de la table `emprunts`
--

INSERT INTO `emprunts` (`id`, `livre_id`, `membre_id`, `date_emprunt`, `date_retour_prevue`, `date_retour_effective`) VALUES
(1, 2, 1, '2026-02-18', '2026-03-05', '2026-02-18'),
(2, 2, 1, '2026-02-18', '2026-03-05', '2026-02-18'),
(3, 2, 1, '2026-02-18', '2026-03-05', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

DROP TABLE IF EXISTS `livres`;
CREATE TABLE IF NOT EXISTS `livres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `annee` int DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=geostd8;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `auteur`, `annee`, `isbn`, `disponible`) VALUES
(1, 'Le Petit Prince', 'Antoine de Saint-Exup?ry', 1943, '9782070612758', 1),
(2, '1984', 'George Orwell', 1949, '9780451524935', 0),
(3, 'Vingt mille lieues sous les mers', 'Jules Verne', 1870, '9782253006501', 1);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_inscription` date DEFAULT (curdate()),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=geostd8;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `nom`, `prenom`, `email`, `date_inscription`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@email.com', '2026-02-18'),
(2, 'Martin', 'Sophie', 'sophie.martin@email.com', '2026-02-18'),
(3, 'Jean ', 'David', 'andersonmichel981@gmail.com', '2026-02-18'),
(4, 'Pierre Matin', 'David', 'admin@example.com', '2026-02-18');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','super_admin') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=geostd8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `role`) VALUES
(4, 'Marc', '$2y$10$UWzE/GbUzwZJ0DKaG7ReQecAwiobov2ihQtHIPRcyuAaiKtknTopG', 'admin'),
(2, 'Anderson', '$2y$10$If6c.XYQVbznSe4FqHVcc.m4dtYSQXn/H/2XALSvwNbZKFxK6Duxi', 'admin'),
(1, 'SuperAdmin', '$2y$10$VPJebGrWGVbCYx0wvv2kKOQ7XBlbkPwSGKcx.i6q0nuroNjj9KONa', 'super_admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
