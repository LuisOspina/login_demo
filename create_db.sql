-- Create the database
DROP DATABASE IF EXISTS login_demo;
CREATE DATABASE login_demo;
USE login_demo;

-- create table
CREATE TABLE users(
    id INT (11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    sensitivedata VARCHAR(255) NOT NULL
);
