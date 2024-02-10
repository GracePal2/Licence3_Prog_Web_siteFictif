-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 08 déc. 2023 à 22:46
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fruits_paradise`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_art` int NOT NULL,
  `id_stripe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `url_photo` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id_art`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_art`, `id_stripe`, `nom`, `quantite`, `prix`, `url_photo`, `description`) VALUES
(1, 'price_1OIVtuGoxrm9DONFNOQWgmbR', 'Mangue', 4, 2.95, 'https://media.auchan.fr/A0219870327000035108PRIMARY_1500x1500/B2CD/', 'Ce produit est un fruit provenant du manguier classé dans la familles des plantes Anacardiaceae.Des variétés provenant de la Côte d\'Ivoire, de la Guadeloupe et de la réunion sont disponibles.'),
(2, 'price_1OKg7ZGoxrm9DONFpMs55NV7', 'Fraise', 22, 2.2, 'https://saveurs-paysannes-cremieu.fr/wp-content/uploads/2021/04/fraises-2.jpg', 'Les fraises sont de petits fruits rouges contenant de la vitamine C et B6, du fer et du Magnésium.Elles sont toutes issues de la production 100% française.');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `id_stripe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `adresse` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `numero` int DEFAULT NULL,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mdp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `id_stripe`, `nom`, `prenom`, `adresse`, `numero`, `mail`, `mdp`) VALUES
(1, '', 'Miss', 'Paula', '22 RUE STAR', NULL, 'miss.paula@gmail.com', '&é\"\''),
(10, '', 'Benosmane', 'Yacine', '09 rue salace', 192837465, 'ya.benosmane@gmail.com', '$2y$10$NOTWiXY29ehjrngac.6cX.hpOLTc23VpAQjospVwbdS4lz3.I5BDO'),
(11, 'cus_P9AWGbdLtKDLrC', 'Julie', 'Nièvre', '66 rue star', 1234098765, 'inesregu@mail.com', '$2y$10$nEbjHJk27M3r8MVYYI.toePGqxFI0X3OoY/oSw.NwiIBPIRNYV82W'),
(12, '', 'HGIKI', 'NHJ', '67KM?', 2147483647, 'inesregu@mail.com', '$2y$10$RU7c5oOtWKA/rqbRs7D61OGoIQGlewdC.aPrihwFZ7f4SCxHr56SC'),
(13, 'cus_P9KXNY64m5i5jb', 'Zola', 'Emile', '33 rue Calvador', 1234567890, 'emilezog@gmail.com', '$2y$10$Ot5Z2ZJxzMwHkQRUyfPRVe.vBWf7hOCH2ryL3Yi4V/kVowb/iZw8i');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_art` int DEFAULT NULL,
  `id_client` int DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `envoi` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_commande`),
  KEY `id_art` (`id_art`),
  KEY `id_client` (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_art`, `id_client`, `quantite`, `envoi`) VALUES
(1, 1, 13, 6, 1),
(2, 1, 13, 6, 1),
(3, 2, 13, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `content` text,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
