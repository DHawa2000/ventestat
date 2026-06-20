-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2026 at 08:26 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ventestat`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `libelle`, `categorie`, `prix`, `stock`) VALUES
(1, 'Riz local (25kg)', 'Alimentation', 18000.00, 49),
(2, 'Sucre en poudre (1kg)', 'Alimentation', 700.00, 100),
(3, 'Huile végétale (5L)', 'Alimentation', 6500.00, 40),
(4, 'Mil local (50kg)', 'Céréales', 20000.00, 30),
(5, 'Maïs (50kg)', 'Céréales', 15000.00, 45),
(6, 'Tomates en boîte', 'Conserves', 500.00, 120),
(7, 'Savon de ménage', 'Hygiène', 300.00, 200),
(8, 'Dentifrice', 'Hygiène', 1200.00, 80),
(9, 'Bissap séché', 'Boissons', 2500.00, 60),
(10, 'Gingembre frais', 'Épices', 1000.00, 70),
(11, 'Boubou traditionnel', 'Textile', 12000.00, 20),
(12, 'Tissu bazin', 'Textile', 8000.00, 35),
(13, 'Chaussures artisanales', 'Mode', 15000.00, 25);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `quantite` int NOT NULL,
  `date_vente` datetime DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sale_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `quantite`, `date_vente`, `total`, `sale_date`) VALUES
(1, 1, 2, '2026-06-18 20:03:07', 36000.00, '2026-06-18 20:03:07'),
(2, 2, 5, '2026-06-18 20:03:07', 3500.00, '2026-06-18 20:03:07'),
(3, 3, 1, '2026-06-18 20:03:07', 6500.00, '2026-06-18 20:03:07'),
(4, 4, 3, '2026-06-18 20:03:07', 60000.00, '2026-06-18 20:03:07'),
(5, 5, 2, '2026-06-18 20:03:07', 30000.00, '2026-06-18 20:03:07'),
(6, 6, 10, '2026-06-18 20:03:07', 5000.00, '2026-06-18 20:03:07'),
(7, 7, 4, '2026-06-18 20:03:07', 1200.00, '2026-06-18 20:03:07'),
(8, 8, 2, '2026-06-18 20:03:07', 2400.00, '2026-06-18 20:03:07'),
(9, 9, 3, '2026-06-18 20:03:07', 7500.00, '2026-06-18 20:03:07'),
(10, 10, 5, '2026-06-18 20:03:07', 5000.00, '2026-06-18 20:03:07'),
(11, 1, 1, '2026-06-18 20:10:28', 18000.00, '2026-06-18 20:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$/K0TgRKAocGwZ21ZPhRqpu.2IkXh1vNwF9cL8iQSmEHXc74ImlHVS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
