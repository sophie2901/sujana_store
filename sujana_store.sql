-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 02:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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

CREATE TABLE `cart` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(13, 9, 25, 1),
(12, 9, 27, 1),
(14, 9, 17, 1),
(15, 10, 28, 1),
(24, 14, 16, 1),
(18, 11, 15, 1),
(23, 14, 20, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `email` text NOT NULL,
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_city` text DEFAULT NULL,
  `shipping_province` varchar(50) DEFAULT NULL,
  `shipping_postal_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `email`, `shipping_name`, `shipping_address`, `shipping_city`, `shipping_province`, `shipping_postal_code`, `created_at`) VALUES
(6, 15, 485.88, 'willsmith@gmail.com', 'Will Smith', '123 Main St', 'Brampton', 'ON', 'L6Y 7L7', '2025-07-24 19:21:20'),
(5, 13, 507.36, 'janedoe@gmail.com', 'Jane Doe', '123 Main St', 'Brampton', 'ON', 'L6Y 7L7', '2025-07-24 18:58:43'),
(4, 7, 56.49, 'punsujana26@gmail.com', 'Sujana Pun', '123 Main St', 'Brampton', 'ON', 'L6Y 1S7', '2025-07-24 15:04:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(11, 6, 25, 1, 49.99),
(10, 6, 13, 1, 379.99),
(9, 5, 25, 1, 49.99),
(8, 5, 17, 1, 399.00),
(7, 4, 25, 1, 49.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `status` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category`, `stock`, `status`, `created_at`) VALUES
(25, 'Amazon Echo Dot (5th Gen)', 'Smart Speaker with Alexa', 49.99, '/uploads/64145075_L.jpg', 'Smart Home', 200, 'active', '2025-07-24 04:41:12'),
(26, 'Google Nest Thermostat', 'Programmable Smart Thermostat', 129.99, '/uploads/14961201.jpg', 'Smart Home', 40, 'active', '2025-07-24 04:41:12'),
(11, 'Samsung Galaxy S24', '6.1\" AMOLED Display, 128GB Storage', 799.99, '/uploads/images.jpg', 'Smartphone', 50, 'active', '2025-07-24 04:41:12'),
(12, 'iPhone 15 Pro', 'A17 Bionic Chip, 256GB Storage', 999.99, '/uploads/iPhone_15_Pro_Black_Titanium_PDP_Image_Position-1__CAEN_0cff9979-49c4-4325-a507-a6af9ad6eae1.png', 'Smartphone', 60, 'active', '2025-07-24 04:41:12'),
(13, 'Sony WH-1000XM5', 'Noise-Cancelling Wireless Headphones', 379.99, '/uploads/51aXvjzcukL.jpg', 'Headphones', 100, 'active', '2025-07-24 04:41:12'),
(14, 'Dell XPS 13', '13.3\" Laptop, Intel i7, 16GB RAM', 1199.00, '/uploads/images (1).jpg', 'Laptop', 25, 'active', '2025-07-24 04:41:12'),
(15, 'MacBook Air M3', '13\" Retina, 512GB SSD', 1299.99, '/uploads/refurb-mba13-m3-midnight-202405.jpg', 'Laptop', 30, 'active', '2025-07-24 04:41:12'),
(16, 'Logitech MX Master 3S', 'Advanced Wireless Mouse', 99.99, '/uploads/mx-master-3s-for-business-gallery-1.png', 'Accessories', 200, 'active', '2025-07-24 04:41:12'),
(17, 'Apple Watch Series 9', 'GPS, 45mm, Aluminum Case', 399.00, '/uploads/Apple-Watch-S9-graphite-stainless-steel-FineWoven-Magenetic-Link-green-230912_inline.jpg.large.jpg', 'Smartwatch', 75, 'active', '2025-07-24 04:41:12'),
(18, 'Fitbit Charge 6', 'Fitness Tracker with GPS', 159.95, '/uploads/61wn2jfhBkL.jpg', 'Smartwatch', 90, 'active', '2025-07-24 04:41:12'),
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

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `is_admin`) VALUES
(9, 'Stacy', 'Adams', 'stacyadams1@gmail.com', '$2y$10$y70UhUzXSFgQyrlvN.9QTeUx/V7nHK9nMI3LKcwHyOxJa9ipalgHe', 0),
(8, 'Sophie', 'Maya', 'sophiemaya1@gmail.com', '$2y$10$HOAW87D002afjulGCbGlnuwc2EQreb6fhq1zsZwpqWfAuMyEoMIdm', 0),
(7, 'Sujana', 'Pun', 'punsujana26@gmail.com', '$2y$10$37zOXhmfy2gyRR237jZchO6c7094qQnSrqlEmFdBgUrIm56Zeisz.', 1),
(15, 'Will', 'Smith', 'willsmith@gmail.com', '$2y$10$kWxmjtJzFFxGvBw6e5f75u.x/M6/m07Uj1nUwgTyCihV37FdCPRz.', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
