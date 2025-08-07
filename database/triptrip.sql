-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2025 at 03:33 PM
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
-- Database: `triptrip`
--

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(10) NOT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `package_rating` float DEFAULT NULL,
  `package_desc` text DEFAULT NULL,
  `package_start` date DEFAULT NULL,
  `package_end` date DEFAULT NULL,
  `package_price` int(10) DEFAULT NULL,
  `package_location` varchar(255) DEFAULT NULL,
  `is_hotel` int(10) DEFAULT 0,
  `is_transport` int(10) DEFAULT 0,
  `is_food` int(10) DEFAULT 0,
  `is_guide` int(10) DEFAULT 0,
  `package_capacity` int(10) DEFAULT 0,
  `package_booked` int(10) UNSIGNED DEFAULT 0,
  `master_image` text DEFAULT NULL,
  `extra_image_1` text DEFAULT NULL,
  `extra_image_2` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `package_name`, `package_rating`, `package_desc`, `package_start`, `package_end`, `package_price`, `package_location`, `is_hotel`, `is_transport`, `is_food`, `is_guide`, `package_capacity`, `package_booked`, `master_image`, `extra_image_1`, `extra_image_2`) VALUES
(1, 'livingstone tour', 5, 'to see the victoria false', '2024-10-24', '2024-10-31', 10000, 'lusaka', 1, 1, 1, 1, 50, 9, 'img/5.jpg', 'img/3.jpg', 'img/4.jpg'),
(2, 'livingstone tour chanda', NULL, 'hey', '2024-11-22', '2024-12-07', 6000, 'kabwe', 0, 1, 1, 1, 5, 1, 'img/chris.jpg', 'img/WIN_20240725_09_24_11_Pro.jpg', 'img/WIN_20240725_09_24_11_Pro.jpg'),
(3, 'sweet tour', NULL, 'so sweet', '2024-11-02', '2024-11-30', 7000, 'livingstone', 1, 1, 1, 0, 3, 3, 'img/Helicopter-above-the-Vic-Falls-scaled-1536x979.jpg', 'img/4.jpg', 'img/devilspoolcam.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) NOT NULL,
  `trans_id` varchar(255) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `package_id` int(10) DEFAULT NULL,
  `trans_amount` int(10) DEFAULT NULL,
  `trans_date` timestamp NULL DEFAULT NULL,
  `card_no` varchar(255) DEFAULT NULL,
  `val_id` varchar(255) DEFAULT NULL,
  `card_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `trans_id`, `user_id`, `package_id`, `trans_amount`, `trans_date`, `card_no`, `val_id`, `card_type`) VALUES
(14, '8166583', 4, 3, 7000, '2024-11-01 10:37:07', '', '', 'mobilemoneyzm'),
(15, '8166657', 4, 2, 6000, '2024-11-01 11:20:33', '', '', 'mobilemoneyzm'),
(16, '9396001', NULL, 1, 10000, '2025-05-31 11:35:19', '', '', 'mobilemoneyzm'),
(18, '9396065', 8, 3, 7000, '2025-05-31 12:26:59', '', '', 'mobilemoneyzm');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` int(10) DEFAULT 0,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `account_status` int(10) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `user_pass`, `email`, `date_created`, `is_admin`, `phone`, `address`, `full_name`, `account_status`) VALUES
(3, 'danny', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'alison@gmail.com', '2024-10-24 14:10:34', 0, NULL, NULL, '', 1),
(4, 'chimbwi', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'dannychanda05@gmail.com', '2024-10-24 14:10:11', 0, NULL, NULL, '', 1),
(5, 'ackim', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'ackimlegacy1@gmail.com', '2024-11-01 12:11:51', 0, NULL, NULL, '', 1),
(6, 'mampi', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'mampi05@gmail.com', '2024-11-06 09:11:18', 0, NULL, NULL, '', 1),
(8, 'briankayai', '8c37ad1d22e160b8f75b511818f0eae81da13ce2', 'briankayai7@gmail.com', '2025-05-31 12:05:38', 0, NULL, NULL, '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `testimonials_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE SET NULL;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
