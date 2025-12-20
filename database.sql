-- Pet Adoption System Database
-- Create Database

CREATE DATABASE IF NOT EXISTS pet_adoption;

USE pet_adoption;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    address TEXT,
    usertype ENUM('Adopter', 'Owner', 'Shelter', 'Admin') NOT NULL,
    terms_accepted TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pets Table
CREATE TABLE pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    breed VARCHAR(100),
    category ENUM('Dog', 'Cat', 'Bird', 'Rabbit', 'Hamster', 'Fish', 'Other') NOT NULL DEFAULT 'Other',
    picture VARCHAR(255),
    description TEXT,
    featured ENUM('Yes', 'No') DEFAULT 'No',
    gender ENUM('Male', 'Female') NOT NULL,
    user_id INT NOT NULL,
    age INT,
    approval_status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    adoption_status ENUM('Available', 'Adopted') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Adoption History Table
CREATE TABLE adoption (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adopter_id INT NOT NULL,
    owner_id INT NOT NULL,
    pet_id INT NOT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (adopter_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (owner_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (pet_id) REFERENCES pets(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Adoption Request Table
CREATE TABLE adopt_request (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adopter_id INT NOT NULL,
    owner_id INT NOT NULL,
    pet_id INT NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (adopter_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (owner_id) REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    FOREIGN KEY (pet_id) REFERENCES pets(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4;

