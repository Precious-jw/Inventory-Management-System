-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 15, 2025 at 11:06 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `entered_by` varchar(155) DEFAULT NULL,
  `descr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` bigint DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_delete` int NOT NULL DEFAULT '0' COMMENT '0=not deleted, 1=deleted',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `entered_by`, `descr`, `amount`, `date`, `is_delete`) VALUES
(1, 'Precious Newssy', 'Fuel for gen', 3500, '2025-07-09 23:05:38', 0),
(2, 'Precious Newssy', 'Paid salary', 23000, '2025-07-09 23:06:44', 0),
(3, 'Precious Newssy', 'Another fuel', 4500, '2025-07-09 23:07:16', 0),
(4, 'Precious Newssy', 'another salary', 34000, '2025-07-09 23:07:16', 0),
(6, 'Precious Newssy', 'Something nice', 1300, '2025-07-12 09:19:34', 0),
(7, 'Precious Newssy', 'Demo', 4890, '2025-07-12 09:21:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_name` varchar(255) NOT NULL,
  `purchase_price` int NOT NULL,
  `sale_price` int NOT NULL,
  `product_qty` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `date`, `product_name`, `purchase_price`, `sale_price`, `product_qty`) VALUES
(1, '2024-07-04 21:51:22', 'Cup', 100, 150, 120),
(2, '2024-09-28 15:26:35', '15 watts bulb', 250, 300, 23);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` bigint NOT NULL,
  `products` varchar(255) NOT NULL,
  `purchase_price` int DEFAULT NULL,
  `quantity` bigint NOT NULL,
  `discount` bigint DEFAULT NULL,
  `total_price` int NOT NULL,
  `payment_method` varchar(10) NOT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0' COMMENT '0=not deleted, 1=deleted',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `customer_name`, `customer_phone`, `products`, `purchase_price`, `quantity`, `discount`, `total_price`, `payment_method`, `deleted`) VALUES
(10, '2025-07-12 13:09:59', 'erytuy', 0, '15 watts bulb', 300, 7, 0, 2100, 'Cash', 0),
(8, '2025-06-26 00:13:46', 'Tari', 8067545454, 'Cup', 150, 22, 200, 3100, 'Cash', 0),
(9, '2025-07-01 18:37:30', 'Henry', 987628473, 'Cup', 150, 23, 2000, 1450, 'Cash', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `business_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` bigint NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `role` int NOT NULL DEFAULT '1',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `business_name`, `username`, `phone`, `address`, `pass`, `role`, `date`) VALUES
(1, 'Precious Newssy', 'ifakaprecious43@gmail.com', 'My Business Enterprise', 'Precious43', 90376532322, 'No 1 benin city road.', '$2y$10$a.gOv.kHJCR2fMs9S4IM8ecgA9sMooJp7yQUa/FdcalAkCeJWvuam', 2, '2024-06-30 10:33:10'),
(2, 'John Doe', 'john@gmail.com', 'My Business Enterprise', 'john123', 90832776232, NULL, '11111111', 1, '2024-11-14 10:18:52'),
(3, 'Edgar Reichert', 'demo@gmail.com', 'My Business Enterprise', 'Olga43', 261, NULL, '11111111', 0, '2024-11-14 10:22:19');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
