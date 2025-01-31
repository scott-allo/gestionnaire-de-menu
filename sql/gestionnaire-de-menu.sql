-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generated on: Tue, 28 Jan 2025 at 15:22
-- Server version: 8.0.40
-- PHP version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestionnaire-de-menu`
--

-- --------------------------------------------------------

--
-- Table structure for `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Entrée'),
(2, 'Plat principal'),
(3, 'Dessert'),
(4, 'Boissons'),
(5, 'Accompagnements'),
(6, 'Sauces');
-- --------------------------------------------------------

--
-- Table structure for `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`) VALUES
(1, 'Tomate'),
(2, 'Mozzarella'),
(3, 'Poulet'),
(4, 'Boeuf'),
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
-- Table structure for `dishes`
--

CREATE TABLE `dishes` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dishes`
--
INSERT INTO `dishes` (`id`, `name`, `description`, `price`, `image`, `category_id`, `created_at`) VALUES
(1, 'Salade César', 'Salade composée de laitue, poulet, croûtons et parmesan', 12.50, 'images/caesar_salad.jpg', 1, '2025-01-28 16:20:01'),
(2, 'Pizza Margherita', 'Pizza avec sauce tomate, mozzarella et basilic', 9.90, 'images/margherita_pizza.jpg', 2, '2025-01-28 16:20:01'),
(3, 'Burger Classique', 'Burger avec steak, fromage, tomate et laitue', 14.00, 'images/classic_burger.jpg', 2, '2025-01-28 16:20:01'),
(4, 'Lasagne Bolognaise', 'Pâtes en couches avec viande, sauce tomate et fromage', 13.50, 'images/lasagna.jpg', 2, '2025-01-28 16:20:01'),
(5, 'Soupe de légumes', 'Soupe chaude faite avec des légumes frais', 8.00, 'images/vegetable_soup.jpg', 1, '2025-01-28 16:20:01'),
(6, 'Tiramisu', 'Dessert italien à base de mascarpone et café', 6.00, 'images/tiramisu.jpg', 3, '2025-01-28 16:20:01'),
(7, 'Mousse au chocolat', 'Dessert léger et chocolaté', 5.50, 'images/chocolate_mousse.jpg', 3, '2025-01-28 16:20:01'),
(8, 'Filet de saumon grillé', 'Filet de saumon grillé avec des légumes de saison', 18.00, 'images/grilled_salmon.jpg', 2, '2025-01-28 16:20:01'),
(9, 'Frites maison', 'Frites fraîches et croquantes', 4.00, 'images/homemade_fries.jpg', 5, '2025-01-28 16:20:01'),
(10, 'Sauce au poivre', 'Sauce crémeuse au poivre', 2.50, 'images/pepper_sauce.jpg', 6, '2025-01-28 16:20:01');
-- --------------------------------------------------------

--
-- Table structure for `dishes_ingredients`
--

CREATE TABLE `dishes_ingredients` (
  `id` int NOT NULL,
  `dish_id` int NOT NULL,
  `ingredient_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dishes_ingredients`
--

INSERT INTO `dishes_ingredients` (`id`, `dish_id`, `ingredient_id`) VALUES
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
-- Table structure for `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `dishes_ingredients`
--
ALTER TABLE `dishes_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dishes_ingredients`
--
ALTER TABLE `dishes_ingredients`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dishes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `dishes_ingredients`
--
ALTER TABLE `dishes_ingredients`
  ADD CONSTRAINT `dishes_ingredients_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`),
  ADD CONSTRAINT `dishes_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);
COMMIT;