-- Spotify Code Rebuilt demo database
CREATE DATABASE IF NOT EXISTS spotify_code_rebuilt CHARACTER SET utf8mb4;
USE spotify_code_rebuilt;

-- Members (a code encodes the 10-char `licence` ID)
CREATE TABLE IF NOT EXISTS joueur (
    licence   VARCHAR(10)  PRIMARY KEY,
    nom       VARCHAR(50)  NOT NULL,
    prenom    VARCHAR(50)  NOT NULL,
    id_equipe INT,
    poste     VARCHAR(30)
);

-- Demo-site accounts, linked to a player license
CREATE TABLE IF NOT EXISTS inscrit (
    licence VARCHAR(10)  PRIMARY KEY,
    mail    VARCHAR(255) NOT NULL UNIQUE,
    mdp     VARCHAR(255) NOT NULL, -- password_hash()
    FOREIGN KEY (licence) REFERENCES joueur(licence)
);

INSERT IGNORE INTO joueur (licence, nom, prenom, id_equipe, poste) VALUES
    ('AB12345678', 'Martin', 'Lucas',  1, 'Developer'),
    ('CD98765432', 'Durand', 'Emma',   1, 'Designer'),
    ('EF24681357', 'Petit',  'Hugo',   2, 'Manager');
