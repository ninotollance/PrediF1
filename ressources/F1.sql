-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 21 avr. 2026 à 08:49
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
-- Base de données : `F1`
--

-- --------------------------------------------------------

--
-- Structure de la table `BET`
--

CREATE TABLE `BET` (
  `id` int(11) NOT NULL,
  `date_` datetime DEFAULT NULL,
  `idDriver` int(11) NOT NULL,
  `idRace` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `BET`
--

INSERT INTO `BET` (`id`, `date_`, `idDriver`, `idRace`, `idUser`) VALUES
(12, '2026-04-13 15:07:51', 19, 1, 1),
(13, '2026-04-13 16:28:28', 19, 2, 1),
(26, '2026-04-16 15:45:02', 1, 6, 1),
(29, '2026-04-20 19:07:40', 4, 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `DRIVER`
--

CREATE TABLE `DRIVER` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `number_api` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `idTeam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `DRIVER`
--

INSERT INTO `DRIVER` (`id`, `name`, `firstName`, `number_api`, `picture`, `idTeam`) VALUES
(1, 'Norris', 'Lando', 1, '', 1),
(2, 'Verstappen', 'Max', 3, NULL, 2),
(3, 'Bortoleto', 'Gabriel', 5, NULL, 3),
(4, 'Hadjar', 'Isack', 6, NULL, 2),
(5, 'Gasly', 'Pierre', 10, NULL, 4),
(6, 'Perez', 'Sergio', 11, NULL, 5),
(7, 'Antonelli', 'Kimi', 12, NULL, 6),
(8, 'Alonso', 'Fernando', 14, NULL, 7),
(9, 'Leclerc', 'Charles', 16, NULL, 8),
(10, 'Stroll', 'Lance', 18, NULL, 7),
(11, 'Albon', 'Alexander', 23, NULL, 9),
(12, 'Hulkenberg', 'Nico', 27, NULL, 3),
(13, 'Lawson', 'Liam', 30, NULL, 10),
(14, 'Ocon', 'Esteban', 31, NULL, 11),
(15, 'Lindblad', 'Arvid', 41, NULL, 10),
(16, 'Colapinto', 'Franco', 43, NULL, 4),
(17, 'Hamilton', 'Lewis', 44, NULL, 8),
(18, 'Sainz', 'Carlos', 55, NULL, 9),
(19, 'Russell', 'George', 63, NULL, 6),
(20, 'Bottas', 'Valtteri', 77, NULL, 5),
(21, 'Piastri', 'Oscar', 81, NULL, 1),
(22, 'Bearman', 'Oliver', 87, NULL, 11);

-- --------------------------------------------------------

--
-- Structure de la table `DRIVE_IN`
--

CREATE TABLE `DRIVE_IN` (
  `idRace` int(11) NOT NULL,
  `idDriver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `DRIVE_IN`
--

INSERT INTO `DRIVE_IN` (`idRace`, `idDriver`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(6, 9),
(6, 10),
(6, 11),
(6, 12),
(6, 13),
(6, 14),
(6, 15),
(6, 16),
(6, 17),
(6, 18),
(6, 19),
(6, 20),
(6, 21),
(6, 22),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(7, 6),
(7, 7),
(7, 8),
(7, 9),
(7, 10),
(7, 11),
(7, 12),
(7, 13),
(7, 14),
(7, 15),
(7, 16),
(7, 17),
(7, 18),
(7, 19),
(7, 20),
(7, 21),
(7, 22),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(8, 6),
(8, 7),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(8, 12),
(8, 13),
(8, 14),
(8, 15),
(8, 16),
(8, 17),
(8, 18),
(8, 19),
(8, 20),
(8, 21),
(8, 22),
(9, 1),
(9, 2),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(9, 8),
(9, 9),
(9, 10),
(9, 11),
(9, 12),
(9, 13),
(9, 14),
(9, 15),
(9, 16),
(9, 17),
(9, 18),
(9, 19),
(9, 20),
(9, 21),
(9, 22),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(10, 6),
(10, 7),
(10, 8),
(10, 9),
(10, 10),
(10, 11),
(10, 12),
(10, 13),
(10, 14),
(10, 15),
(10, 16),
(10, 17),
(10, 18),
(10, 19),
(10, 20),
(10, 21),
(10, 22),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(11, 6),
(11, 7),
(11, 8),
(11, 9),
(11, 10),
(11, 11),
(11, 12),
(11, 13),
(11, 14),
(11, 15),
(11, 16),
(11, 17),
(11, 18),
(11, 19),
(11, 20),
(11, 21),
(11, 22),
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(12, 7),
(12, 8),
(12, 9),
(12, 10),
(12, 11),
(12, 12),
(12, 13),
(12, 14),
(12, 15),
(12, 16),
(12, 17),
(12, 18),
(12, 19),
(12, 20),
(12, 21),
(12, 22),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(13, 5),
(13, 6),
(13, 7),
(13, 8),
(13, 9),
(13, 10),
(13, 11),
(13, 12),
(13, 13),
(13, 14),
(13, 15),
(13, 16),
(13, 17),
(13, 18),
(13, 19),
(13, 20),
(13, 21),
(13, 22),
(14, 1),
(14, 2),
(14, 3),
(14, 4),
(14, 5),
(14, 6),
(14, 7),
(14, 8),
(14, 9),
(14, 10),
(14, 11),
(14, 12),
(14, 13),
(14, 14),
(14, 15),
(14, 16),
(14, 17),
(14, 18),
(14, 19),
(14, 20),
(14, 21),
(14, 22),
(15, 1),
(15, 2),
(15, 3),
(15, 4),
(15, 5),
(15, 6),
(15, 7),
(15, 8),
(15, 9),
(15, 10),
(15, 11),
(15, 12),
(15, 13),
(15, 14),
(15, 15),
(15, 16),
(15, 17),
(15, 18),
(15, 19),
(15, 20),
(15, 21),
(15, 22),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(16, 6),
(16, 7),
(16, 8),
(16, 9),
(16, 10),
(16, 11),
(16, 12),
(16, 13),
(16, 14),
(16, 15),
(16, 16),
(16, 17),
(16, 18),
(16, 19),
(16, 20),
(16, 21),
(16, 22),
(17, 1),
(17, 2),
(17, 3),
(17, 4),
(17, 5),
(17, 6),
(17, 7),
(17, 8),
(17, 9),
(17, 10),
(17, 11),
(17, 12),
(17, 13),
(17, 14),
(17, 15),
(17, 16),
(17, 17),
(17, 18),
(17, 19),
(17, 20),
(17, 21),
(17, 22),
(18, 1),
(18, 2),
(18, 3),
(18, 4),
(18, 5),
(18, 6),
(18, 7),
(18, 8),
(18, 9),
(18, 10),
(18, 11),
(18, 12),
(18, 13),
(18, 14),
(18, 15),
(18, 16),
(18, 17),
(18, 18),
(18, 19),
(18, 20),
(18, 21),
(18, 22),
(19, 1),
(19, 2),
(19, 3),
(19, 4),
(19, 5),
(19, 6),
(19, 7),
(19, 8),
(19, 9),
(19, 10),
(19, 11),
(19, 12),
(19, 13),
(19, 14),
(19, 15),
(19, 16),
(19, 17),
(19, 18),
(19, 19),
(19, 20),
(19, 21),
(19, 22),
(20, 1),
(20, 2),
(20, 3),
(20, 4),
(20, 5),
(20, 6),
(20, 7),
(20, 8),
(20, 9),
(20, 10),
(20, 11),
(20, 12),
(20, 13),
(20, 14),
(20, 15),
(20, 16),
(20, 17),
(20, 18),
(20, 19),
(20, 20),
(20, 21),
(20, 22),
(21, 1),
(21, 2),
(21, 3),
(21, 4),
(21, 5),
(21, 6),
(21, 7),
(21, 8),
(21, 9),
(21, 10),
(21, 11),
(21, 12),
(21, 13),
(21, 14),
(21, 15),
(21, 16),
(21, 17),
(21, 18),
(21, 19),
(21, 20),
(21, 21),
(21, 22),
(22, 1),
(22, 2),
(22, 3),
(22, 4),
(22, 5),
(22, 6),
(22, 7),
(22, 8),
(22, 9),
(22, 10),
(22, 11),
(22, 12),
(22, 13),
(22, 14),
(22, 15),
(22, 16),
(22, 17),
(22, 18),
(22, 19),
(22, 20),
(22, 21),
(22, 22),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 5),
(23, 6),
(23, 7),
(23, 8),
(23, 9),
(23, 10),
(23, 11),
(23, 12),
(23, 13),
(23, 14),
(23, 15),
(23, 16),
(23, 17),
(23, 18),
(23, 19),
(23, 20),
(23, 21),
(23, 22),
(24, 1),
(24, 2),
(24, 3),
(24, 4),
(24, 5),
(24, 6),
(24, 7),
(24, 8),
(24, 9),
(24, 10),
(24, 11),
(24, 12),
(24, 13),
(24, 14),
(24, 15),
(24, 16),
(24, 17),
(24, 18),
(24, 19),
(24, 20),
(24, 21),
(24, 22);

-- --------------------------------------------------------

--
-- Structure de la table `RACE`
--

CREATE TABLE `RACE` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `circuitKey_api` int(11) NOT NULL,
  `idWinner` int(11) DEFAULT NULL,
  `gpStart` date DEFAULT NULL,
  `gpEnd` date DEFAULT NULL,
  `raceStart` datetime DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `RACE`
--

INSERT INTO `RACE` (`id`, `name`, `country`, `circuitKey_api`, `idWinner`, `gpStart`, `gpEnd`, `raceStart`, `picture`, `status`) VALUES
(1, 'Formula 1 Qatar Airways Australian Grand Prix', 'Australie', 10, 19, '2026-03-06', '2026-03-08', '2026-03-08 05:00:00', 'Australie.webp', 'finished'),
(2, 'Formula 1 Heineken Chinese Grand Prix', 'Chine', 49, 7, '2026-03-13', '2026-03-15', '2026-03-15 08:00:00', 'Chine.webp', 'finished'),
(3, 'Formula 1 Aramco Japanese Grand Prix', 'Japon', 46, 7, '2026-03-27', '2026-03-29', '2026-03-29 07:00:00', 'Japon.webp', 'finished'),
(6, 'Formula 1 Crypto.com Miami Grand Prix', 'États-Unis', 151, NULL, '2026-05-01', '2026-05-03', '2026-05-03 22:00:00', 'Miami.webp', 'scheduled'),
(7, 'Formula 1 Lenovo Grand Prix du Canada', 'Canada', 23, NULL, '2026-05-22', '2026-05-24', '2026-05-24 22:00:00', 'Canada.webp', 'scheduled'),
(8, 'Formula 1 Louis Vuitton Grand Prix de Monaco', 'Monaco', 22, NULL, '2026-06-05', '2026-06-07', '2026-06-07 15:00:00', 'Monaco.webp', 'scheduled'),
(9, 'Formula 1 MSC Cruises Gran Premio de Barcelona', 'Espagne', 15, NULL, '2026-06-12', '2026-06-14', '2026-06-14 15:00:00', NULL, 'scheduled'),
(10, 'Formula 1 Lenovo Austrian Grand Prix', 'Autriche', 19, NULL, '2026-06-26', '2026-06-28', '2026-06-28 15:00:00', 'Autriche.webp', 'scheduled'),
(11, 'Formula 1 Pirelli British Grand Prix', 'Royaume-Uni', 2, NULL, '2026-07-03', '2026-07-05', '2026-07-05 16:00:00', 'Royaume-Uni.webp', 'scheduled'),
(12, 'Formula 1 Belgian Grand Prix', 'Belgique', 7, NULL, '2026-07-17', '2026-07-19', '2026-07-19 15:00:00', 'Belgique.webp', 'scheduled'),
(13, 'Formula 1 AWS Hungarian Grand Prix', 'Hongrie', 4, NULL, '2026-07-24', '2026-07-26', '2026-07-26 15:00:00', NULL, 'scheduled'),
(14, 'Formula 1 Heineken Dutch Grand Prix', 'Pays-Bas', 55, NULL, '2026-08-21', '2026-08-23', '2026-08-23 15:00:00', NULL, 'scheduled'),
(15, 'Formula 1 Pirelli Gran Premio d\'Italia', 'Italie', 39, NULL, '2026-09-04', '2026-09-06', '2026-09-06 15:00:00', NULL, 'scheduled'),
(16, 'Formula 1 Tag Heuer Gran Premio de España', 'Espagne', 153, NULL, '2026-09-11', '2026-09-13', '2026-09-13 15:00:00', NULL, 'scheduled'),
(17, 'Formula 1 Qatar Airways Azerbaijan Grand Prix', 'Azerbaïdjan', 144, NULL, '2026-09-24', '2026-09-26', '2026-09-26 13:00:00', NULL, 'scheduled'),
(18, 'Formula 1 Singapore Airlines Singapore Grand Prix', 'Singapour', 61, NULL, '2026-10-09', '2026-10-11', '2026-10-11 14:00:00', NULL, 'scheduled'),
(19, 'Formula 1 MSC Cruises United States Grand Prix', 'États-Unis', 9, NULL, '2026-10-23', '2026-10-25', '2026-10-25 21:00:00', NULL, 'scheduled'),
(20, 'Formula 1 Gran Premio de la Ciudad de México', 'Mexique', 65, NULL, '2026-10-30', '2026-11-01', '2026-11-01 21:00:00', NULL, 'scheduled'),
(21, 'Formula 1 MSC Cruises Grande Prêmio de São Paulo', 'Brésil', 14, NULL, '2026-11-06', '2026-11-08', '2026-11-01 18:00:00', NULL, 'scheduled'),
(22, 'Formula 1 Heineken Las Vegas Grand Prix', 'États-Unis', 152, NULL, '2026-11-20', '2026-11-22', '2026-11-21 05:00:00', NULL, 'scheduled'),
(23, 'Formula 1 Qatar Airways Qatar Grand Prix', 'Qatar', 150, NULL, '2026-11-27', '2026-11-29', '2026-11-29 17:00:00', NULL, 'scheduled'),
(24, 'Formula 1 Etihad Airways Abu Dhabi Grand Prix', 'Émirats Arabes Unis', 70, NULL, '2026-12-04', '2026-12-06', '2026-12-06 14:00:00', NULL, 'scheduled');

-- --------------------------------------------------------

--
-- Structure de la table `TEAM`
--

CREATE TABLE `TEAM` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `TEAM`
--

INSERT INTO `TEAM` (`id`, `name`, `country`, `picture`) VALUES
(1, 'McLaren', 'Royaume-Uni', 'mcLaren.webp'),
(2, 'Red Bull Racing', 'Autriche', 'redbull.webp'),
(3, 'Audi', 'Allemagne', NULL),
(4, 'Alpine', 'France', 'alpine.webp'),
(5, 'Cadillac', 'États-Unis', NULL),
(6, 'Mercedes', 'Allemagne', 'mercedes.webp'),
(7, 'Aston Martin', 'Royaume-Uni', 'astonMartin.jpg'),
(8, 'Ferrari', 'Italie', 'ferrari.webp'),
(9, 'Williams', 'Royaume-Uni', 'williams .webp'),
(10, 'Racing Bulls', 'Italie', 'racingbull.webp'),
(11, 'Haas', 'États-Unis', 'Hass.webp');

-- --------------------------------------------------------

--
-- Structure de la table `USER_`
--

CREATE TABLE `USER_` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `USER_`
--

INSERT INTO `USER_` (`id`, `name`, `firstName`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin', 'admin@predif1.com', '$2y$10$AxPltv9ii7zrSQkBzVe/1.O21HPc2cJ/AAjQots1gXLp25S4ylsxi', 'admin'),
(6, 'Tollance', 'Nino', 'nino@kercode.fr', '$2y$10$8VQgKTzJsh/g3SYM1jarWO6KW9WvS.dz4ByIfhKq1tS9VS1N1bjsK', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `BET`
--
ALTER TABLE `BET`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDriver` (`idDriver`),
  ADD KEY `idRace` (`idRace`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `DRIVER`
--
ALTER TABLE `DRIVER`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTeam` (`idTeam`);

--
-- Index pour la table `DRIVE_IN`
--
ALTER TABLE `DRIVE_IN`
  ADD PRIMARY KEY (`idRace`,`idDriver`),
  ADD KEY `idDriver` (`idDriver`);

--
-- Index pour la table `RACE`
--
ALTER TABLE `RACE`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idWinner` (`idWinner`);

--
-- Index pour la table `TEAM`
--
ALTER TABLE `TEAM`
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
-- AUTO_INCREMENT pour la table `BET`
--
ALTER TABLE `BET`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `DRIVER`
--
ALTER TABLE `DRIVER`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `RACE`
--
ALTER TABLE `RACE`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `TEAM`
--
ALTER TABLE `TEAM`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `USER_`
--
ALTER TABLE `USER_`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `BET`
--
ALTER TABLE `BET`
  ADD CONSTRAINT `BET_ibfk_1` FOREIGN KEY (`idDriver`) REFERENCES `DRIVER` (`id`),
  ADD CONSTRAINT `BET_ibfk_2` FOREIGN KEY (`idRace`) REFERENCES `RACE` (`id`),
  ADD CONSTRAINT `BET_ibfk_3` FOREIGN KEY (`idUser`) REFERENCES `USER_` (`id`);

--
-- Contraintes pour la table `DRIVER`
--
ALTER TABLE `DRIVER`
  ADD CONSTRAINT `DRIVER_ibfk_1` FOREIGN KEY (`idTeam`) REFERENCES `TEAM` (`id`);

--
-- Contraintes pour la table `DRIVE_IN`
--
ALTER TABLE `DRIVE_IN`
  ADD CONSTRAINT `DRIVE_IN_ibfk_1` FOREIGN KEY (`idRace`) REFERENCES `RACE` (`id`),
  ADD CONSTRAINT `DRIVE_IN_ibfk_2` FOREIGN KEY (`idDriver`) REFERENCES `DRIVER` (`id`);

--
-- Contraintes pour la table `RACE`
--
ALTER TABLE `RACE`
  ADD CONSTRAINT `RACE_ibfk_1` FOREIGN KEY (`idWinner`) REFERENCES `DRIVER` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
