-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2026 at 12:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kavanabread`
--
CREATE DATABASE IF NOT EXISTS `kavanabread` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kavanabread`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `status`) VALUES
(12, 41, 'active'),
(13, 42, 'active'),
(14, 43, 'active'),
(15, 44, 'active'),
(16, 45, 'active'),
(17, 46, 'active'),
(18, 47, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `cart_products`
--

DROP TABLE IF EXISTS `cart_products`;
CREATE TABLE `cart_products` (
  `cart_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `username`, `lastname`, `email`, `password`) VALUES
(41, 'kkrkrkrkrknek', 'krkrkrk', 'rrrr@gmail.com', '$2y$10$XM5B.9Z3/lf7b38NEypuTOkiZHzs2eNC4gPrmONuti3.WwMXFJ6.S'),
(42, 'michi', 'uhiuiug', 'deeses@gmail.com', '$2y$10$ZOdb4vC0.R1xJVg/nCysDezdtTeHV9IabH3qI02Kiu/5AasD00Loq'),
(43, 'wdwdkwdkwdk', 'msmfdkmkdcmd', 'mmm@gmail.com', '$2y$10$IOqGuDwpbE64deAaqH9tSOK2PrqRtM18qwzwLFe7OaSXQMWVL1SpS'),
(44, 'admin', 'admin', 'admin@admin.com', '$2y$10$hgEhI3MP3fUsI6qaGxHUQeK6GgkZVSywGUFsOZ/1lM7pqrqHkkvNC'),
(45, 'ekekeke', 'kekeke', 'mm2@gmail.com', '$2y$10$w4gUsK0CgGXB8C/YmwssreriyH/X9hJE.T9TbDXxjJCsTMibM5APa'),
(46, 'nininin ', 'jdjdjj', 'ggg@gmail.com', '$2y$10$0PBzlDDlMulw8biUue0uVOn7pBq2t3X10IHHPWsf1DwXouc.kQ5si'),
(47, 'juan', 'garcia', 'juan@gmail.com', '$2y$10$KIPulcT9QJIZSQgILMCaUumQYC7.cX8jHe.HdN2E6ugOWD8WmJipi');

-- --------------------------------------------------------

--
-- Table structure for table `loginadmins`
--

DROP TABLE IF EXISTS `loginadmins`;
CREATE TABLE `loginadmins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loginadmins`
--

INSERT INTO `loginadmins` (`id`, `user_id`) VALUES
(1, 44);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `Product_ID` int(11) NOT NULL,
  `Product_Name` varchar(50) NOT NULL,
  `Price` decimal(6,2) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Product_ID`, `Product_Name`, `Price`, `Quantity`) VALUES
(1, 'Pan Sobao', 1.25, 15),
(2, 'Pan Criollo', 2.09, 1),
(3, 'Baguette', 2.00, 1),
(4, 'Croissant', 2.00, 1),
(5, 'Dounut', 2.00, 1),
(6, 'Muffin', 2.00, 1),
(7, 'Honeybun', 2.00, 1),
(8, 'Pan Sobao integral', 2.99, 1),
(9, 'Donas Regulares', 2.50, 15),
(12, 'Dona rellenas', 1.50, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `id` (`id`,`Product_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `loginadmins`
--
ALTER TABLE `loginadmins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cart_products`
--
ALTER TABLE `cart_products`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `loginadmins`
--
ALTER TABLE `loginadmins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_products`
--
ALTER TABLE `cart_products`
  ADD CONSTRAINT `cart_products_ibfk_1` FOREIGN KEY (`id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_products_ibfk_2` FOREIGN KEY (`Product_ID`) REFERENCES `products` (`Product_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loginadmins`
--
ALTER TABLE `loginadmins`
  ADD CONSTRAINT `loginadmins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `login` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
