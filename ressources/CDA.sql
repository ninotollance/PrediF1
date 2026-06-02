-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 02 juin 2026 à 09:36
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `CDA`
--

-- --------------------------------------------------------

--
-- Structure de la table `CLIENT`
--

CREATE TABLE `CLIENT` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `CLIENT`
--

INSERT INTO `CLIENT` (`id`, `name`, `firstName`, `phone`, `address`, `zipCode`, `city`) VALUES
(2, 'Tollance', 'Nino', '0123456789', '20 rue Winston Churchill', '56000', 'Vannes'),
(3, 'Hamilton', 'Lewis', '9876543210', '1 rue Enzo Ferrari', '41053', 'Maranello'),
(4, 'Wembanyama', 'Victor', '35715986240', '10 rue san antonio', '00000', 'San Antonio');

-- --------------------------------------------------------

--
-- Structure de la table `USER_`
--

CREATE TABLE `USER_` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `USER_`
--

INSERT INTO `USER_` (`id`, `name`, `firstName`, `email`, `password`, `role`) VALUES
(1, 'Nino', 'Tollance', 'nino@kercode.fr', '$2y$10$/T2i2ttRlkYjKM4IKTsjh.RpVsNCqbomPydLY9rTy.IZ0khKLIsdG', 'admin'),
(3, 'Dupont', 'Jean', 'Dupont@jean.fr', '$2y$10$SQA.re0Hv4Ib4ywdiRU.qO0yIonXWVQqeN4vGIZx4y8qzH3IhqzKe', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `CLIENT`
--
ALTER TABLE `CLIENT`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `USER_`
--
ALTER TABLE `USER_`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `CLIENT`
--
ALTER TABLE `CLIENT`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `USER_`
--
ALTER TABLE `USER_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
