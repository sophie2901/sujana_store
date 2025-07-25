-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 24, 2025 at 02:30 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sujana_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint DEFAULT NULL,
  `product_id` bigint DEFAULT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `email` text COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_general_ci,
  `shipping_city` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `shipping_province` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shipping_postal_code` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `email`, `shipping_name`, `shipping_address`, `shipping_city`, `shipping_province`, `shipping_postal_code`, `created_at`) VALUES
(1, 2, 9199.90, 'pragunbaj99@gmail.com', 'Pragun Bajracharya', '41 Mill Street South, L6Y 1S7', 'Brampton', 'ON', 'L6Y 1S7', '2025-07-24 07:09:26'),
(2, 2, 6316.62, 'pragunbaj99@gmail.com', 'Pragun Bajracharya', '225 Malta Avenue', 'Brampton', 'ON', 'L6Y 6L6', '2025-07-24 07:40:35'),
(3, 6, 7785.47, 'punsujana27@gmail.com', 'Sujana Pun', '225 Malta Avenue', 'Brampton', 'ON', 'L6Y 6L6', '2025-07-24 07:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `order_id` bigint DEFAULT NULL,
  `product_id` bigint DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 11, 4, 799.99),
(2, 1, 12, 6, 999.99),
(3, 2, 26, 3, 129.99),
(4, 2, 15, 4, 1299.99),
(5, 3, 15, 5, 1299.99),
(6, 3, 29, 3, 129.95);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `stock` int DEFAULT '0',
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category`, `stock`, `status`, `created_at`) VALUES
(25, 'Amazon Echo Dot (5th Gen)', 'Smart Speaker with Alexa', 49.99, '/uploads/64145075_L.jpg', 'Smart Home', 80, 'active', '2025-07-24 04:41:12'),
(26, 'Google Nest Thermostat', 'Programmable Smart Thermostat', 129.99, '/uploads/14961201.jpg', 'Smart Home', 40, 'active', '2025-07-24 04:41:12'),
(11, 'Samsung Galaxy S24', '6.1\" AMOLED Display, 128GB Storage', 799.99, '/uploads/images.jpg', 'Smartphone', 50, 'active', '2025-07-24 04:41:12'),
(12, 'iPhone 15 Pro', 'A17 Bionic Chip, 256GB Storage', 999.99, '/uploads/iPhone_15_Pro_Black_Titanium_PDP_Image_Position-1__CAEN_0cff9979-49c4-4325-a507-a6af9ad6eae1.png', 'Smartphone', 40, 'active', '2025-07-24 04:41:12'),
(13, 'Sony WH-1000XM5', 'Noise-Cancelling Wireless Headphones', 379.99, '/uploads/51aXvjzcukL.jpg', 'Headphones', 100, 'active', '2025-07-24 04:41:12'),
(14, 'Dell XPS 13', '13.3\" Laptop, Intel i7, 16GB RAM', 1199.00, '/uploads/images (1).jpg', 'Laptop', 25, 'active', '2025-07-24 04:41:12'),
(15, 'MacBook Air M3', '13\" Retina, 512GB SSD', 1299.99, '/uploads/refurb-mba13-m3-midnight-202405.jpg', 'Laptop', 30, 'active', '2025-07-24 04:41:12'),
(16, 'Logitech MX Master 3S', 'Advanced Wireless Mouse', 99.99, '/uploads/mx-master-3s-for-business-gallery-1.png', 'Accessories', 200, 'active', '2025-07-24 04:41:12'),
(17, 'Apple Watch Series 9', 'GPS, 45mm, Aluminum Case', 399.00, '/uploads/Apple-Watch-S9-graphite-stainless-steel-FineWoven-Magenetic-Link-green-230912_inline.jpg.large.jpg', 'Smartwatch', 75, 'active', '2025-07-24 04:41:12'),
(18, 'Fitbit Charge 6', 'Fitness Tracker with GPS', 159.95, '/uploads/61wn2jfhBkL.jpg', 'Smartwatch', 90, 'active', '2025-07-24 04:41:12'),
(19, 'ASUS ROG Strix G15', 'Gaming Laptop, Ryzen 9, RTX 4070', 1699.00, '/uploads/strix-g-2022.png', 'Laptop', 15, 'active', '2025-07-24 04:41:12'),
(20, 'Canon EOS R50', 'Mirrorless Camera with 18-45mm Lens', 679.00, '/uploads/71ANGtyZRzL.jpg', 'Camera', 12, 'active', '2025-07-24 04:41:12'),
(21, 'GoPro HERO12 Black', 'Waterproof Action Camera', 399.99, '/uploads/81RrX9Y+faL._UF894,1000_QL80_.jpg', 'Camera', 60, 'active', '2025-07-24 04:41:12'),
(22, 'Anker PowerCore 10000', 'Portable Charger, 10000mAh', 29.99, '/uploads/61RsRGUZORL.jpg', 'Accessories', 150, 'active', '2025-07-24 04:41:12'),
(23, 'Samsung 65', '4K UHD Smart TV with HDR', 899.99, '/uploads/81JGWpKbHDL.jpg', 'Television', 20, 'active', '2025-07-24 04:41:12'),
(24, 'LG 55', '4K UHD Smart OLED TV', 1099.00, '/uploads/55qned80t_2024_product_image_front.jpg', 'Television', 18, 'active', '2025-07-24 04:41:12'),
(27, 'Razer BlackWidow V4', 'Mechanical Gaming Keyboard', 179.99, '/uploads/81Wsrt05uLL.jpg', 'Accessories', 35, 'active', '2025-07-24 04:41:12'),
(28, 'Microsoft Surface Pro 9', '13\" 2-in-1 Tablet, i5, 256GB SSD', 999.99, '/uploads/04oXeqT4MuFbMo7fc7QSrAx-2.fit_lim.size_1200x630.v1680110421.jpg', 'Laptop', 22, 'active', '2025-07-24 04:41:12'),
(29, 'JBL Flip 6', 'Portable Bluetooth Speaker', 129.95, '/uploads/61Eaj593GtL.jpg', 'Speaker', 70, 'active', '2025-07-24 04:41:12'),
(30, 'TP-Link Archer AX73', 'AX5400 WiFi 6 Router', 179.99, '/uploads/51RoyFl5dEL.jpg', 'Networking', 45, 'active', '2025-07-24 04:41:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `is_admin`) VALUES
(2, 'Pragun', 'Bajracharya', 'pragunbaj99@gmail.com', '$2y$10$5s65PVVmGhFEYR.b8Rbovu5X78b7.xopWvxMb2.zArsZCmu9i5MW2', 1),
(5, 'Pragun', 'Bajracharya', 'pragunbaj00@gmail.com', '$2y$10$.B019YxvWfHTpXHo6yByBe2eCmAvPObfF/LULrxXjVP1VbuKfUfrq', 0),
(6, 'Sujana', 'Pun', 'punsujana27@gmail.com', '$2y$10$AH5sC2Jc0DqDOnpZMUrQp.V0DnxM16TbAZcUTnsYb0QIH4Qu0H7/.', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
