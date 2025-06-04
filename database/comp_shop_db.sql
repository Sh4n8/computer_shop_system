-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 04, 2025 at 04:07 PM
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

-- Create the table with auto-increment and unique constraints
CREATE TABLE IF NOT EXISTS tblcomputer (
    computer_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    computer_name VARCHAR(100) NOT NULL UNIQUE,
    status ENUM('Available', 'In Use', 'Maintenance', 'Offline') NOT NULL DEFAULT 'Available',
    last_updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
