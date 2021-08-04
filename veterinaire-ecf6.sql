-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : synolego.synology.me:44132
-- Généré le : mer. 04 août 2021 à 19:10
-- Version du serveur :  8.0.26-0ubuntu0.20.04.2
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `veterinaire-ecf6`
--

-- --------------------------------------------------------

--
-- Structure de la table `Animal`
--

CREATE TABLE `Animal` (
  `Id` int NOT NULL,
  `Nom` varchar(20) DEFAULT NULL,
  `DateNaissance` date DEFAULT NULL,
  `DateDeces` date DEFAULT NULL,
  `idProprietaire` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Chat`
--

CREATE TABLE `Chat` (
  `idAnimal` int NOT NULL,
  `idRace` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Chien`
--

CREATE TABLE `Chien` (
  `idAnimal` int NOT NULL,
  `taille` varchar(45) DEFAULT NULL,
  `Poids` varchar(45) DEFAULT NULL,
  `idRace` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `creneauxDispos`
--

CREATE TABLE `creneauxDispos` (
  `id` int NOT NULL,
  `jour` date NOT NULL,
  `heureDebut` time NOT NULL,
  `heureFin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `creneauxDispos`
--

INSERT INTO `creneauxDispos` (`id`, `jour`, `heureDebut`, `heureFin`) VALUES
(1, '2021-08-03', '10:00:00', '11:00:00'),
(2, '2021-08-03', '16:00:00', '17:00:00'),
(3, '2021-09-05', '09:00:00', '10:00:00'),
(6, '2021-09-06', '09:00:00', '10:00:00'),
(7, '2021-09-07', '14:00:00', '15:00:00'),
(8, '2021-10-02', '12:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `Dossier`
--

CREATE TABLE `Dossier` (
  `id` int NOT NULL,
  `antecedents` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Effectuer`
--

CREATE TABLE `Effectuer` (
  `idVeterinaire` int NOT NULL,
  `idGarde` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Garde`
--

CREATE TABLE `Garde` (
  `id` int NOT NULL,
  `date` date DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Horaire`
--

CREATE TABLE `Horaire` (
  `id` int NOT NULL,
  `jour` date DEFAULT NULL,
  `heureDebut` time DEFAULT NULL,
  `heureFin` time DEFAULT NULL,
  `idVeterinaire` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Horaire`
--

INSERT INTO `Horaire` (`id`, `jour`, `heureDebut`, `heureFin`, `idVeterinaire`) VALUES
(1, '2021-05-05', '09:00:00', '17:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Medicament`
--

CREATE TABLE `Medicament` (
  `id` int NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `dosage` varchar(45) DEFAULT NULL,
  `indications` text,
  `effetsSecondaires` text,
  `laboratoire` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Prescrire`
--

CREATE TABLE `Prescrire` (
  `idVisite` int NOT NULL,
  `idMedicament` int DEFAULT NULL,
  `posologie` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Proprietaire`
--

CREATE TABLE `Proprietaire` (
  `id` int NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `rue` varchar(45) DEFAULT NULL,
  `codePostal` int DEFAULT NULL,
  `ville` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `telephoneMobile` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Race_chat`
--

CREATE TABLE `Race_chat` (
  `id` int NOT NULL,
  `nom` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Race_chien`
--

CREATE TABLE `Race_chien` (
  `id` int NOT NULL,
  `nom` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE `Users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` char(60) NOT NULL,
  `admin` int DEFAULT NULL,
  `pseudo` varchar(50) NOT NULL,
  `idVeterinaire` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `Users`
--

INSERT INTO `Users` (`id`, `email`, `password`, `admin`, `pseudo`, `idVeterinaire`) VALUES
(20, 'colin.legoedec@laposte.net', '637264c33586ebf30110be4f57215f79354500f6', 1, 'colinleg', 2);

-- --------------------------------------------------------

--
-- Structure de la table `Veterinaire`
--

CREATE TABLE `Veterinaire` (
  `id` int NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `telephoneMobile` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `Veterinaire`
--

INSERT INTO `Veterinaire` (`id`, `nom`, `prenom`, `telephone`, `telephoneMobile`) VALUES
(1, 'Jean', 'Dumont', '0784454684', '0456445859'),
(2, 'Maryse', 'Dupond', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Visite`
--

CREATE TABLE `Visite` (
  `id` int NOT NULL,
  `date` date DEFAULT NULL,
  `heureVisite` time DEFAULT NULL,
  `raison` varchar(45) DEFAULT NULL,
  `idDossier` int NOT NULL,
  `idAnimal` int NOT NULL,
  `idVeterinaire` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Animal`
--
ALTER TABLE `Animal`
  ADD PRIMARY KEY (`Id`,`idProprietaire`);

--
-- Index pour la table `Chat`
--
ALTER TABLE `Chat`
  ADD KEY `indexAnimal` (`idAnimal`) USING BTREE,
  ADD KEY `indexRace` (`idRace`);

--
-- Index pour la table `Chien`
--
ALTER TABLE `Chien`
  ADD KEY `inddexAnimal` (`idAnimal`),
  ADD KEY `indexRace` (`idRace`);

--
-- Index pour la table `creneauxDispos`
--
ALTER TABLE `creneauxDispos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Dossier`
--
ALTER TABLE `Dossier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Effectuer`
--
ALTER TABLE `Effectuer`
  ADD PRIMARY KEY (`idVeterinaire`),
  ADD KEY `GARDE` (`idGarde`);

--
-- Index pour la table `Garde`
--
ALTER TABLE `Garde`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Horaire`
--
ALTER TABLE `Horaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Horaire_Veterinaire_idx` (`idVeterinaire`);

--
-- Index pour la table `Medicament`
--
ALTER TABLE `Medicament`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Prescrire`
--
ALTER TABLE `Prescrire`
  ADD PRIMARY KEY (`idVisite`),
  ADD KEY `fk_Prescrire_2_idx` (`idMedicament`),
  ADD KEY `fk_Prescrire_1_idx` (`idVisite`);

--
-- Index pour la table `Proprietaire`
--
ALTER TABLE `Proprietaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Race_chat`
--
ALTER TABLE `Race_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index1` (`id`) USING BTREE;

--
-- Index pour la table `Race_chien`
--
ALTER TABLE `Race_chien`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idVeterinaire` (`idVeterinaire`);

--
-- Index pour la table `Veterinaire`
--
ALTER TABLE `Veterinaire`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Visite`
--
ALTER TABLE `Visite`
  ADD PRIMARY KEY (`id`,`idDossier`,`idAnimal`,`idVeterinaire`),
  ADD KEY `fk_Visite_2_idx` (`idDossier`),
  ADD KEY `fk_Visite_1_idx` (`idAnimal`),
  ADD KEY `fk_Veterinaire_idx` (`idVeterinaire`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `creneauxDispos`
--
ALTER TABLE `creneauxDispos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `Dossier`
--
ALTER TABLE `Dossier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Horaire`
--
ALTER TABLE `Horaire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Medicament`
--
ALTER TABLE `Medicament`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Proprietaire`
--
ALTER TABLE `Proprietaire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Race_chat`
--
ALTER TABLE `Race_chat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Race_chien`
--
ALTER TABLE `Race_chien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `Veterinaire`
--
ALTER TABLE `Veterinaire`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `Visite`
--
ALTER TABLE `Visite`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Animal`
--
ALTER TABLE `Animal`
  ADD CONSTRAINT `fk_Animal_1` FOREIGN KEY (`Id`) REFERENCES `Proprietaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Chat`
--
ALTER TABLE `Chat`
  ADD CONSTRAINT `fk_Chat` FOREIGN KEY (`idAnimal`) REFERENCES `Animal` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_raceChat` FOREIGN KEY (`idRace`) REFERENCES `Race_chat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Chien`
--
ALTER TABLE `Chien`
  ADD CONSTRAINT `fk_Animal` FOREIGN KEY (`idAnimal`) REFERENCES `Animal` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_raceChien` FOREIGN KEY (`idRace`) REFERENCES `Race_chien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Dossier`
--
ALTER TABLE `Dossier`
  ADD CONSTRAINT `fk_dossier_proprietaire` FOREIGN KEY (`id`) REFERENCES `Proprietaire` (`id`);

--
-- Contraintes pour la table `Effectuer`
--
ALTER TABLE `Effectuer`
  ADD CONSTRAINT `fk_Effectuer_Veterinaire` FOREIGN KEY (`idVeterinaire`) REFERENCES `Veterinaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Garde`
--
ALTER TABLE `Garde`
  ADD CONSTRAINT `fk_Effectuer` FOREIGN KEY (`id`) REFERENCES `Effectuer` (`idGarde`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Horaire`
--
ALTER TABLE `Horaire`
  ADD CONSTRAINT `fk_Horaire_Veterinaire` FOREIGN KEY (`idVeterinaire`) REFERENCES `Veterinaire` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Prescrire`
--
ALTER TABLE `Prescrire`
  ADD CONSTRAINT `fk_Prescrire_1` FOREIGN KEY (`idVisite`) REFERENCES `Visite` (`id`),
  ADD CONSTRAINT `fk_Prescrire_2` FOREIGN KEY (`idMedicament`) REFERENCES `Medicament` (`id`);

--
-- Contraintes pour la table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `fk_idVeterinaire` FOREIGN KEY (`idVeterinaire`) REFERENCES `Veterinaire` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `Visite`
--
ALTER TABLE `Visite`
  ADD CONSTRAINT `fk_Veterinaire` FOREIGN KEY (`idVeterinaire`) REFERENCES `Veterinaire` (`id`),
  ADD CONSTRAINT `fk_Visite_1` FOREIGN KEY (`idAnimal`) REFERENCES `Animal` (`Id`),
  ADD CONSTRAINT `fk_Visite_2` FOREIGN KEY (`idDossier`) REFERENCES `Dossier` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
