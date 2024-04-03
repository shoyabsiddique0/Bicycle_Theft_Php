-- Create database if not exists
CREATE DATABASE IF NOT EXISTS bicycle_theft_db;

-- Use the database
USE bicycle_theft_db;

-- Table for storing user information
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('public', 'police') NOT NULL
);

-- Table for storing bicycle information
CREATE TABLE IF NOT EXISTS bicycles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    brand VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    color VARCHAR(50) NOT NULL,
    serial_number VARCHAR(50) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table for storing stolen bicycle reports
CREATE TABLE IF NOT EXISTS stolen_bicycles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bicycle_id INT NOT NULL,
    report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('reported', 'under investigation', 'recovered') DEFAULT 'reported',
    FOREIGN KEY (bicycle_id) REFERENCES bicycles(id)
);

-- Table for storing police officers
CREATE TABLE IF NOT EXISTS police_officers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table for storing enrolled police officers
CREATE TABLE IF NOT EXISTS enrolled_police (
    id INT AUTO_INCREMENT PRIMARY KEY,
    officer_id INT NOT NULL,
    admin_id INT NOT NULL,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (officer_id) REFERENCES police_officers(id),
    FOREIGN KEY (admin_id) REFERENCES police_officers(id)
);
