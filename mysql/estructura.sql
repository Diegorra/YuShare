-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-03-2022 a las 03:28:23
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2


CREATE TABLE IF NOT EXISTS `Usuario` (
    id INT NOT NULL AUTO_INCREMENT,
    userName VARCHAR(20) NOT NULL,
    passwd VARCHAR(256) NOT NULL,
    email VARCHAR(256) NOT NULL,
    image VARCHAR(256) NOT NULL,
    enabled boolean NOT NULL,
    role ENUM('ADMIN_ROLE', 'USER_ROLE'),
    PRIMARY KEY (id),
    UNIQUE (userName)
);

CREATE TABLE IF NOT EXISTS `UsuarioBaneado`(
    id INT NOT NULL,
    fecha datetime,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES Usuario(id) ON DELETE CASCADE 

);

CREATE TABLE IF NOT EXISTS `Pelicula` (
    id INT NOT NULL AUTO_INCREMENT,
    iduser INT NOT NULL,
    titulo VARCHAR(256) NOT NULL,
    text VARCHAR(256) NOT NULL,
    genero ENUM('Aventuras', 'Comedia', 'Drama', 'Terror', 'Musical', 'Documental'),
    src VARCHAR(256),
    numerototalLikes Int,
    trailer VARCHAR(256) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (iduser) REFERENCES Usuario(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Comentario` (
    id INT NOT NULL AUTO_INCREMENT,
    idpubli INT NOT NULL,
    iduser INT NOT NULL,
    text VARCHAR(256) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (idpubli) REFERENCES Pelicula(id) ON DELETE CASCADE,
    FOREIGN KEY (iduser) REFERENCES Usuario(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Amigo` (
    idAmigo INT NOT NULL,
    idUsuario INT NOT NULL,
    nombreAmigo VARCHAR(256) NOT NULL,
    estado ENUM('Agregado', 'Pendiente'),
    PRIMARY KEY (idAmigo, idUsuario),
    FOREIGN KEY (idAmigo) REFERENCES Usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (idUsuario) REFERENCES Usuario(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Mensaje` (
    id INT NOT NULL AUTO_INCREMENT,
    iduser1 INT NOT NULL,
    iduser2 INT NOT NULL,
    Text VARCHAR(256),
    PRIMARY KEY (id),
    FOREIGN KEY (iduser1) REFERENCES Usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (iduser2) REFERENCES Usuario(id) ON DELETE CASCADE
);
