-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 28 jan. 2025 à 15:22
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionnaire-de-menu`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Entrée'),
(2, 'Plat principal'),
(3, 'Dessert'),
(4, 'Boissons'),
(5, 'Accompagnements'),
(6, 'Sauces');

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`id`, `nom`) VALUES
(1, 'Tomate'),
(2, 'Mozzarella'),
(3, 'Poulet'),
(4, 'Bœuf'),
(5, 'Saumon'),
(6, 'Crème fraîche'),
(7, 'Parmesan'),
(8, 'Laitue'),
(9, 'Pain'),
(10, 'Champignons'),
(11, 'Oignons'),
(12, 'Pâtes'),
(13, 'Riz'),
(14, 'Basilic'),
(15, 'Thon'),
(16, 'Fraises'),
(17, 'Chocolat'),
(18, 'Sucre'),
(19, 'Citron'),
(20, 'Menthe');

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

CREATE TABLE `plats` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id_categorie` int NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`id`, `nom`, `description`, `prix`, `image`, `id_categorie`, `date_creation`) VALUES
(1, 'Salade César', 'Salade composée de laitue, poulet, croûtons et parmesan', 12.50, 'images/salade_cesar.jpg', 1, '2025-01-28 16:20:01'),
(2, 'Pizza Margherita', 'Pizza à la sauce tomate, mozzarella et basilic', 9.90, 'images/pizza_margherita.jpg', 2, '2025-01-28 16:20:01'),
(3, 'Burger Classique', 'Burger avec steak, fromage, tomate et laitue', 14.00, 'images/burger_classique.jpg', 2, '2025-01-28 16:20:01'),
(4, 'Lasagnes Bolognese', 'Pâtes en couches avec viande, sauce tomate et fromage', 13.50, 'images/lasagnes.jpg', 2, '2025-01-28 16:20:01'),
(5, 'Soupe de légumes', 'Soupe chaude à base de légumes frais', 8.00, 'images/soupe_legumes.jpg', 1, '2025-01-28 16:20:01'),
(6, 'Tiramisu', 'Dessert italien à base de mascarpone et café', 6.00, 'images/tiramisu.jpg', 3, '2025-01-28 16:20:01'),
(7, 'Mousse au chocolat', 'Dessert léger et chocolaté', 5.50, 'images/mousse_chocolat.jpg', 3, '2025-01-28 16:20:01'),
(8, 'Filet de saumon', 'Filet de saumon grillé avec légumes de saison', 18.00, 'images/filet_saumon.jpg', 2, '2025-01-28 16:20:01'),
(9, 'Frites maison', 'Frites fraîches et croustillantes', 4.00, 'images/frites_maison.jpg', 5, '2025-01-28 16:20:01'),
(10, 'Sauce au poivre', 'Sauce crémeuse au poivre', 2.50, 'images/sauce_poivre.jpg', 6, '2025-01-28 16:20:01');

-- --------------------------------------------------------

--
-- Structure de la table `plats_ingredients`
--

CREATE TABLE `plats_ingredients` (
  `id` int NOT NULL,
  `id_plat` int NOT NULL,
  `id_ingredient` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plats_ingredients`
--

INSERT INTO `plats_ingredients` (`id`, `id_plat`, `id_ingredient`) VALUES
(12, 1, 2),
(13, 1, 3),
(14, 1, 8),
(15, 2, 1),
(16, 2, 2),
(17, 2, 14),
(18, 3, 3),
(19, 3, 1),
(20, 3, 8),
(21, 6, 17),
(22, 6, 18);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `plats`
--
ALTER TABLE `plats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `plats_ingredients`
--
ALTER TABLE `plats_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_plat` (`id_plat`),
  ADD KEY `id_ingredient` (`id_ingredient`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `plats`
--
ALTER TABLE `plats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `plats_ingredients`
--
ALTER TABLE `plats_ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `plats`
--
ALTER TABLE `plats`
  ADD CONSTRAINT `plats_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `plats_ingredients`
--
ALTER TABLE `plats_ingredients`
  ADD CONSTRAINT `plats_ingredients_ibfk_1` FOREIGN KEY (`id_plat`) REFERENCES `plats` (`id`),
  ADD CONSTRAINT `plats_ingredients_ibfk_2` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
