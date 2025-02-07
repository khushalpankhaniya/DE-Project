-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2025 at 02:44 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_brands`
--

CREATE TABLE `a_brands` (
  `id` int(20) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `a_brands`
--

INSERT INTO `a_brands` (`id`, `name`) VALUES
(1, 'computer'),
(2, 'kids'),
(3, 'history');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(61, 11, 'Php', 150, 3, '512su9kPPtL._SX391_BO1,204,203,200_.jpg'),
(62, 13, 'Php', 150, 6, '512su9kPPtL._SX391_BO1,204,203,200_.jpg'),
(73, 0, 'Php', 500, 1, '512su9kPPtL._SX391_BO1,204,203,200_.jpg'),
(79, 0, 'java', 200, 1, '514axA2lwpL.jpg'),
(95, 14, 'Php', 500, 1, '512su9kPPtL._SX391_BO1,204,203,200_.jpg'),
(102, 19, 'javaScript', 200, 1, 'cover.jpg'),
(103, 19, 'etiquette', 52, 1, '81othAc7jGL.jpg'),
(104, 20, 'World History', 500, 1, '51Epp4bidGL._SL500_.jpg'),
(105, 20, 'javaScript', 200, 16, 'cover.jpg'),
(106, 20, 'c++', 300, 1, 'WhatsApp_Image_2021-03-16_at_12.57.08-thumbnail-540x540-70.jpeg'),
(108, 0, 'c++', 300, 1, 'WhatsApp_Image_2021-03-16_at_12.57.08-thumbnail-540x540-70.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(10, 14, 'dhruv', 'dhruv1@gmail.com', '0', '0'),
(11, 0, 'dev', 'dev@gmail.com', '2', 'nice website'),
(12, 0, 'dhruv', 'dhruv1@gmail.com', '5', 'njn'),
(13, 14, 'rohan', 'rohan30@gmail.com', '723656', 'best web\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(10, 2, 'khushal', '1', 'dhruv@gmail.com', 'credit card', 'flat no. 1, c, l, 5 - 123', ', java (1) ', 25, '09-Mar-2023', 'completed'),
(11, 16, 'vfs', '3232', 'dhruv1@gmail.com', 'paypal', 'flat no. 2, fwe, sc, india - 656', ', Php (1) , oli (1) ', 525, '13-Apr-2023', 'completed'),
(12, 14, 'dhruv', '951032', 'dhruv@gmail.com', 'credit card', 'flat no. 3, a3, rajkot, uk - 123456', ', Php (1) , m (1) ', 1100, '16-Apr-2023', 'completed'),
(13, 17, 'gf', '20', 'dhruv1@gmail.com', 'cash on delivery', 'flat no. 3, 2, rajkot, india - 6023', ', StoryBook (1) ', 400, '05-Jun-2023', 'completed'),
(14, 19, 'ygu', '654', 'shrut@gmail.com', 'paypal', 'flat no. 1, bh, iy, gyu - 2', ', World History (3) , javaScript (1) ', 1700, '19-Jun-2023', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `brand_id` int(10) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `brand_id`, `price`, `image`) VALUES
(7, 'javaScript', 1, 200, 'cover.jpg'),
(8, 'c++', 1, 300, 'WhatsApp_Image_2021-03-16_at_12.57.08-thumbnail-540x540-70.jpeg'),
(9, 'networking for beginners', 1, 150, '41m4MmahYOL.jpg'),
(10, 'StoryBook', 2, 400, 'blossom-moral-story-book-for-kids-1-years-to-10-years-old-in-original-imagct5wczjgdnzd.jpeg'),
(11, 'etiquette', 2, 52, '81othAc7jGL.jpg'),
(12, 'World History', 3, 500, '51Epp4bidGL._SL500_.jpg'),
(13, 'An Advanced History of india', 3, 60, '612KK3+0aYL.jpg'),
(14, 'AncientIndiaHistory', 3, 500, 'ancient-indian-history-1.jpg'),
(15, 'Perspectives in indian history', 3, 700, 'perspectives-in-indian-history.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(2, 'dhruv', 'dhruv@gmail.com', 'b6d767d2f8ed5d21a44b0e5886680cb9', 'user'),
(3, 'khushal', 'khushaladmin@gmail.com', '3948ead63a9f2944218de038d8934305', 'admin'),
(10, 'java', 'dhruv@gmail.com', 'd3d9446802a44259755d38e6d163e820', 'user'),
(11, 'dhruv', 'dhruv@gmail.com', 'a3c65c2974270fd093ee8a9bf8ae7d0b', 'user'),
(12, 'khushal', 'khushal@gmail.com', '3948ead63a9f2944218de038d8934305', 'admin'),
(13, 'dhruv', 'dhruvm@gmail.com', 'c6f057b86584942e415435ffb1fa93d4', 'user'),
(14, 'dhruv', 'dhruv1@gmail.com', 'b4b147bc522828731f1a016bfa72c073', 'user'),
(15, 'don', 'don@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(16, 'mo', 'mo@gmail.com', 'f033ab37c30201f73f142449d037028d', 'user'),
(17, 'dev', 'dev@gmail.com', 'c6f057b86584942e415435ffb1fa93d4', 'user'),
(18, 'shrut', 'shrut@gmail.com', 'a591024321c5e2bdbd23ed35f0574dde', 'user'),
(19, 'shrutt', 'shrut123@gmail.com', 'ea6edd0f2173ef4e2c6cc6cd648f0136', 'user'),
(20, 'riya ', 'riya@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(21, 'dave', 'dave@gmail.com', '7e8caf6075549eb789234483e6470abe', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
