-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2025 at 08:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Sofia`
--

-- --------------------------------------------------------

--
-- Table structure for table `meal_planning`
--

CREATE TABLE `meal_planning` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_type` enum('breakfast','lunch','dinner') NOT NULL,
  `diet_type` enum('vegetarian','vegan','keto','paleo') NOT NULL,
  `calories` int(4) NOT NULL,
  `meal_time` enum('morning','afternoon','evening') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meal_planning`
--

INSERT INTO `meal_planning` (`id`, `user_id`, `meal_type`, `diet_type`, `calories`, `meal_time`, `created_at`) VALUES
(82, 13, 'breakfast', 'vegetarian', 2000, 'morning', '2025-01-19 18:41:48'),
(88, 14, 'breakfast', 'vegetarian', 2000, 'morning', '2025-01-20 12:49:01'),
(91, 16, 'lunch', 'vegan', 3000, 'afternoon', '2025-01-20 16:43:52'),
(98, 18, 'breakfast', 'vegetarian', 2000, 'morning', '2025-01-20 22:30:41'),
(100, 5, 'lunch', 'vegetarian', 2500, 'morning', '2025-01-21 10:05:42'),
(101, 5, 'breakfast', 'vegetarian', 2000, 'morning', '2025-01-21 17:17:06'),
(102, 5, 'breakfast', 'vegetarian', 2000, 'morning', '2025-01-21 17:18:05'),
(103, 5, 'breakfast', 'vegetarian', 2000, 'morning', '2025-01-22 19:39:25'),
(104, 5, 'breakfast', 'vegetarian', 2000, 'morning', '2025-01-22 19:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `gender`) VALUES
(5, 'sofia', 'skumar@nyc.gr', '$2y$10$c4BLExc0wHGzBlOVx8v/B.fy.b1gxp2W5PJk9eDUyR3Dq0MJCdWGq', 'Female'),
(7, 'sofia', 'kumar@gamil.com', '$2y$10$19cy6.ECwt6jAtZRKXfmY.H3jQ2G2DQ2MMZq31gjIslxe9Ndqs44G', 'Female'),
(13, 'skumar', 'skumar44@gmail.com', '$2y$10$eSDKqZJuPPU.fU5swy2jneLfieSx7lH7pdq5YQO1FVtPSaqoIj2Ta', 'Female'),
(14, 'Redy', 'redy@gmail.com', '$2y$10$oBqqPTllGIz0M8sv3hPKaOIowRujnuoZDt6N7CoLuLNAxnsaa9F4a', 'Male'),
(16, 'rishi', 'rishi@gmail.com', '$2y$10$nF8QRK4ZbKXIg2F5MxCzGOoCoVdTdaeT.9uCOPZ7WjtpcFtwv4VaS', 'Male'),
(18, 'ashok', 'ashok33@gmail.com', '$2y$10$4BRZGhg1IYUGSBA4KdHk2ez9FZ3weDHvRck3tgGCQ6ZVZX5MZ1jhu', 'Female');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `meal_planning`
--
ALTER TABLE `meal_planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `meal_planning`
--
ALTER TABLE `meal_planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meal_planning`
--
ALTER TABLE `meal_planning`
  ADD CONSTRAINT `meal_planning_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
