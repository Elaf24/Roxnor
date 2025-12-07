-- Create database
CREATE DATABASE IF NOT EXISTS roxnor_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE roxnor_db;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Submissions table
CREATE TABLE IF NOT EXISTS submissions (
    id BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
    amount INT(10) NOT NULL,
    buyer VARCHAR(255) NOT NULL,
    receipt_id VARCHAR(20) NOT NULL,
    items VARCHAR(255) NOT NULL,
    buyer_email VARCHAR(50) NOT NULL,
    buyer_ip VARCHAR(20),
    note TEXT NOT NULL,
    city VARCHAR(20) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    hash_key VARCHAR(255),
    entry_at DATE,
    entry_by INT(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

