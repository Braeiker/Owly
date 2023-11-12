-- migrations.sql

-- Creazione del database
CREATE DATABASE IF NOT EXISTS owly_db;

-- Connessione al database
USE owly_db;

-- Creazione della tabella Corsi
CREATE TABLE IF NOT EXISTS Corsi (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_corso VARCHAR(30) NOT NULL,
    numero_studenti INT(30) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Fine del file di migrazione
