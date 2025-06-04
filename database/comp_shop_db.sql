-- Create the database
CREATE DATABASE IF NOT EXISTS comp_shop_db;
USE comp_shop_db;

-- Table for computers
CREATE TABLE IF NOT EXISTS tblcomputer (
    computer_id INT AUTO_INCREMENT PRIMARY KEY,
    computer_name VARCHAR(100) NOT NULL,
    status ENUM('Available', 'In Use') DEFAULT 'Available',
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for sessions
CREATE TABLE IF NOT EXISTS tblsessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    computer_id INT NOT NULL,
    user_name VARCHAR(100) NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME DEFAULT NULL,
    status ENUM('Ongoing', 'Completed') DEFAULT 'Ongoing',
    duration_minutes INT DEFAULT NULL,
    cost DECIMAL(10, 2) DEFAULT NULL,
    FOREIGN KEY (computer_id) REFERENCES tblcomputer(computer_id) ON DELETE CASCADE
);

-- Table for daily or monthly reports
CREATE TABLE IF NOT EXISTS tblreports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_date DATE NOT NULL,
    computer_id INT NOT NULL,
    total_sessions INT DEFAULT 0,
    total_duration INT DEFAULT 0, -- in minutes
    total_earnings DECIMAL(10, 2) DEFAULT 0.00,
    FOREIGN KEY (computer_id) REFERENCES tblcomputer(computer_id) ON DELETE CASCADE
);
