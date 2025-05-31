-- Create the database if not exists
CREATE DATABASE IF NOT EXISTS comp_shop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE comp_shop_db;

-- Create the table with auto-increment and unique constraints
CREATE TABLE IF NOT EXISTS tblcomputer (
    computer_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    computer_name VARCHAR(100) NOT NULL UNIQUE,
    status ENUM('Available', 'In Use', 'Maintenance', 'Offline') NOT NULL DEFAULT 'Available',
    last_updated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
