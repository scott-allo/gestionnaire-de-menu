CREATE DATABASE gestion_menu;

USE gestion_menu;

-- Table utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table plats
CREATE TABLE plats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    id_categorie INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie) REFERENCES categories(id)
);

-- Table ingredients
CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- Table pivot plats_ingredients
CREATE TABLE plats_ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_plat INT NOT NULL,
    id_ingredient INT NOT NULL,
    FOREIGN KEY (id_plat) REFERENCES plats(id),
    FOREIGN KEY (id_ingredient) REFERENCES ingredients(id)
);