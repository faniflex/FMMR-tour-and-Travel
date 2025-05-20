-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 03:17 PM
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
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `Full_name` varchar(100) NOT NULL,
  `arrival_date` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `departure_date` date NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `distination` varchar(100) NOT NULL,
  `special_package` varchar(100) NOT NULL,
  `adult` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `guide` varchar(10) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `booking_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `Full_name`, `arrival_date`, `email`, `departure_date`, `phone_number`, `address`, `distination`, `special_package`, `adult`, `child`, `room_type`, `guide`, `gender`, `booking_date`) VALUES
(1, 'Melkamu Girma', '0000-00-00', 'Array', '2025-05-28', '0941153291', 'Addis ababa', 'Hamer', 'Aksum', 1, 0, 'Single Room', 'NO', 'male', '0000-00-00 00:00:00'),
(2, 'mel', '2025-05-19', 'ze@gmail.com', '2025-05-20', '12636373', 'hhh', 'Fasil', 'Dallol', 1, 0, 'Twin Room', 'NO', 'male', '0000-00-00 00:00:00'),
(3, 'Melkamu Girma', '2025-05-18', 'zemelkgirma@gmail.com', '2025-05-21', '0941153291', 'Addis ababa', 'Fasil', 'Aksum', 1, 0, 'King Room', 'YES', 'male', '2025-05-18 14:41:47');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `Full name` varchar(50) NOT NULL,
  `arrival date` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `departure date` date NOT NULL,
  `phone number` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `distination` varchar(50) NOT NULL,
  `special package` varchar(50) NOT NULL,
  `adult` varchar(50) NOT NULL,
  `child` varchar(20) NOT NULL,
  `room type` varchar(50) NOT NULL,
  `guide` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sex` text NOT NULL,
  `password` varchar(50) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `birthdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `sex`, `password`, `reset_token`, `reset_expires`, `birthdate`) VALUES
(8, 'melkamu', 'girma', 'zemelkgirma@gmail.com', 'Male', '12345', NULL, NULL, '2000-01-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
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
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
