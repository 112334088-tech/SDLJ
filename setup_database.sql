-- ================================================
--  BiteByChoice Database Setup
--  Run this file once to create the database & tables
-- ================================================

CREATE DATABASE IF NOT EXISTS bitebychoice;
USE bitebychoice;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(50)  NOT NULL UNIQUE,
    email       VARCHAR(100) NOT NULL UNIQUE,
    mobile      VARCHAR(15)  NOT NULL,
    password    VARCHAR(255) NOT NULL,       -- stores hashed password
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- (Optional) Sessions / login log table
CREATE TABLE IF NOT EXISTS login_logs (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);