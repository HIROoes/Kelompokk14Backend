-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 03:16 PM
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
-- Database: `db_api1`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `contact` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `status` enum('active','hidden') DEFAULT 'active',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_path`, `contact`, `category`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Kopi Bali Asli', 'Kopi bubuk hasil olahan mahasiswa jurusan TI yang berwirausaha kopi lokal.', 35000.00, 'kopi.jpg', '081234567890', 'Minuman', 'active', 2, '2026-01-19 11:12:53', NULL),
(2, 'Kaos ITB STIKOM Bali', 'Kaos desain kreatif buatan mahasiswa jurusan Sistem Informasi.', 75000.00, 'kaos.jpg', '081234567891', 'Fashion', 'active', 3, '2026-01-19 11:12:53', NULL),
(3, 'Jasa Desain Logo', 'Mahasiswa jurusan Desain menawarkan jasa pembuatan logo profesional.', 150000.00, 'logo.jpg', '081234567892', 'Jasa', 'active', 4, '2026-01-19 11:12:53', NULL),
(4, 'Snack Sehat', 'Produk makanan ringan sehat buatan mahasiswa jurusan Kesehatan.', 20000.00, 'snack.jpg', '081234567890', 'Makanan', 'active', 2, '2026-01-19 11:12:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa',
  `name` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nim` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `name`, `contact`, `created_at`, `nim`, `jurusan`) VALUES
(1, 'admin', 'admin123', 'admin', 'Administrator', 'admin@stikom.ac.id', '2026-01-19 11:12:53', '', ''),
(2, 'wardiana', 'wardiana123', 'mahasiswa', 'Wardiana', '081234567890', '2026-01-19 11:12:53', '', ''),
(3, 'dirga', 'f920c412f0f4bdcbed8aff77b5e44da0', 'mahasiswa', 'Dirga', '081234567891', '2026-01-19 11:12:53', '', ''),
(4, 'dani', '8fc828b696ba1cd92eab8d0a6ffb17d6', 'mahasiswa', 'Dani', '081234567892', '2026-01-19 11:12:53', '', ''),
(5, 'kuwir43', 'haha1', 'mahasiswa', 'kuwir', '08210831028', '2026-01-19 13:44:12', '', ''),
(6, 'ward', 'ward1', 'mahasiswa', 'wardang', '0821083102', '2026-01-19 14:01:18', '240030193', 'si');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
