-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 28, 2025 at 06:10 PM
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
  `product_code` varchar(100) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `purchase_price` int NOT NULL,
  `sale_price` int NOT NULL,
  `retail_price` int DEFAULT NULL,
  `product_qty` int NOT NULL,
  `threshold` int DEFAULT NULL COMMENT 'Low stock limit',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `date`, `product_name`, `product_code`, `company`, `purchase_price`, `sale_price`, `retail_price`, `product_qty`, `threshold`) VALUES
(8, '2025-07-28 17:49:55', 'Towne', '32627-1451', 'Schamberger, Blick and Leannon', 109, 253, 401, 178, 535),
(7, '2025-07-18 00:08:04', 'Green Tiles', '2030', 'Tiles company Limited', 1200, 1350, 1500, 498, 100),
(5, '2025-07-16 23:18:24', 'Tiles', '34326', 'Runolfsdottir', 81, 90, 100, 0, 200),
(4, '2025-07-16 22:19:54', 'Kilback', '54347-2874', 'Schneider - Willms', 96, 597, 587, 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

DROP TABLE IF EXISTS `salary`;
CREATE TABLE IF NOT EXISTS `salary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `entered_by` varchar(255) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `amount` int NOT NULL,
  `month` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`id`, `entered_by`, `staff_name`, `amount`, `month`, `date`, `remarks`) VALUES
(1, 'Precious Newssy', 'gffdfd', 23232, 'June', '2025-07-24 22:26:31', 'Working'),
(3, 'Precious Newssy', 'ererer', 1233, 'February', '2025-07-24 22:35:49', 'Testing'),
(4, 'Precious Newssy', 'dfdfdf', 2222, 'September', '2025-07-24 22:35:49', 'Another one'),
(5, 'Precious Newssy', 'John', 323823, 'March', '2025-07-25 22:03:37', 'Testing again');

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
  `paid` int DEFAULT NULL,
  `payment_method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `deleted` tinyint NOT NULL DEFAULT '0' COMMENT '0=not deleted, 1=deleted',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `customer_name`, `customer_phone`, `products`, `purchase_price`, `quantity`, `discount`, `total_price`, `paid`, `payment_method`, `comments`, `deleted`) VALUES
(1, '2025-07-21 20:18:23', 'Riley', 7888988, 'Green Tiles', 1350, 0, 2000, 3000, 1000, 'Transfer', 'Test', 0),
(2, '2025-07-21 20:39:25', 'Johnny', 0, 'Green Tiles', 1350, 12, 2000, 4200, 1000, 'Cash', '', 1),
(3, '2025-07-27 21:22:30', 'Roony', 0, 'Kilback', 597, 100, 0, 15000, 12000, 'Transfer', '', 0),
(4, '2025-07-28 17:50:40', 'Houston Trantow', 624, 'Towne', 253, 123, 1000, 2800, 2700, 'POS', 'Raynor, Rau and Connelly', 0);

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
