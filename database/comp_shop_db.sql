-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 04, 2025 at 05:03 PM
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
-- Database: `comp_shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbuser`
--

CREATE TABLE `dbuser` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbuser`
--

INSERT INTO `dbuser` (`user_id`, `username`, `password`) VALUES
(1, 'alejandro', 'Ale-Alejandro64');

-- --------------------------------------------------------

--
-- Table structure for table `shopsettings`
--

CREATE TABLE `shopsettings` (
  `id` int(11) NOT NULL,
  `shop_name` varchar(100) NOT NULL,
  `hourly_rate` float NOT NULL,
  `contact_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopsettings`
--

INSERT INTO `shopsettings` (`id`, `shop_name`, `hourly_rate`, `contact_email`) VALUES
(1, 'Cave-Lipa', 30, 'cave_lipa@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tblcomputer`
--

CREATE TABLE `tblcomputer` (
  `computer_id` int(11) NOT NULL,
  `computer_name` varchar(100) NOT NULL,
  `status` enum('Available','In Use') DEFAULT 'Available',
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblreports`
--

CREATE TABLE `tblreports` (
  `report_id` int(11) NOT NULL,
  `report_date` date NOT NULL,
  `computer_id` int(11) NOT NULL,
  `total_sessions` int(11) DEFAULT 0,
  `total_duration` int(11) DEFAULT 0,
  `total_earnings` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsessions`
--

CREATE TABLE `tblsessions` (
  `session_id` int(11) NOT NULL,
  `computer_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` enum('Ongoing','Completed') DEFAULT 'Ongoing',
  `duration_minutes` int(11) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbuser`
--
ALTER TABLE `dbuser`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tblcomputer`
--
ALTER TABLE `tblcomputer`
  ADD PRIMARY KEY (`computer_id`);

--
-- Indexes for table `tblreports`
--
ALTER TABLE `tblreports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `computer_id` (`computer_id`);

--
-- Indexes for table `tblsessions`
--
ALTER TABLE `tblsessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `computer_id` (`computer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbuser`
--
ALTER TABLE `dbuser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcomputer`
--
ALTER TABLE `tblcomputer`
  MODIFY `computer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblreports`
--
ALTER TABLE `tblreports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsessions`
--
ALTER TABLE `tblsessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblreports`
--
ALTER TABLE `tblreports`
  ADD CONSTRAINT `tblreports_ibfk_1` FOREIGN KEY (`computer_id`) REFERENCES `tblcomputer` (`computer_id`) ON DELETE CASCADE;

--
-- Constraints for table `tblsessions`
--
ALTER TABLE `tblsessions`
  ADD CONSTRAINT `tblsessions_ibfk_1` FOREIGN KEY (`computer_id`) REFERENCES `tblcomputer` (`computer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
