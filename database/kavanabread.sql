-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2026 at 05:23 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

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
(17, 46, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `cart_products`
--

CREATE TABLE `cart_products` (
  `cart_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_ID`, `name`) VALUES
(1, 'Pan'),
(2, 'Artesanal'),
(3, 'Snacks');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

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
(49, 'michiru', 'mi', 'michi@gmail.com', '$2y$10$DjVjkWEH803B4o3bQ88waOOivpTT/6EbqT04pqD6T0ttLNlAMRo2u'),
(50, 'Krystal', 'Bracero', 'Kavanabread@gmail.com', '$2y$10$fsokEvtwIwVGkdlzbrBpr.0/5SU8pBNtxHzq0exabb32Ts.nhLIKS');

-- --------------------------------------------------------

--
-- Table structure for table `loginadmins`
--

CREATE TABLE `loginadmins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loginadmins`
--

INSERT INTO `loginadmins` (`id`, `user_id`) VALUES
(1, 44),
(4, 49),
(5, 50);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `Product_ID` int(11) NOT NULL,
  `Product_Name` varchar(50) NOT NULL,
  `category_ID` int(11) NOT NULL,
  `Price` decimal(6,2) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Product_ID`, `Product_Name`, `category_ID`, `Price`, `Quantity`) VALUES
(1, 'Pan Blanco', 1, 1.25, 15),
(2, 'Pan de Semillas', 1, 2.09, 15),
(3, 'Pan de Canela y Pasas', 1, 2.00, 1),
(4, 'Pan de Curcuma', 1, 2.00, 1),
(5, 'Pan de Avena y Miel', 1, 2.00, 1),
(6, 'Mantequilla fresca', 2, 6.00, 1),
(7, 'Jalea de Fresa', 2, 5.00, 1),
(8, 'Jalea de Blueberry', 2, 5.00, 1),
(9, 'Mantequilla Cilantro (3oz)', 2, 5.00, 15),
(12, 'Mantequilla Cilantro (8oz)', 2, 12.00, 10),
(13, 'Nueces y Almendras con Caramelo', 2, 5.00, 25),
(16, 'Nueces y Almendras con Caramelo', 3, 5.00, 1),
(17, 'Cocacha Pan Italiano', 3, 8.00, 1),
(18, 'Tiavaca(4)', 3, 6.00, 1),
(19, 'Granola mix masa madre', 3, 5.00, 1);

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
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_ID`);

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
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `category_ID` (`category_ID`);

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
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `loginadmins`
--
ALTER TABLE `loginadmins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_ID`) REFERENCES `category` (`category_ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
