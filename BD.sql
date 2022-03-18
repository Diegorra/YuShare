drop table if exists usuario;
drop table if exists usuario_baneado;
drop table if exists pelicula;
drop table if exists comentario;
drop table if exists amigo;
drop table if exists mensaje;

CREATE TABLE usuario (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    passwd VARCHAR(256) NOT NULL,
    email VARCHAR(256) NOT NULL,
    image VARCHAR(256),
    enabled boolean NOT NULL,
    role ENUM('ROLE_ADMIN', 'ROLE_USER'),
    PRIMARY KEY (id),
    UNIQUE (email),
    UNIQUE (name)
);

CREATE TABLE usuario_baneado(
    id INT NOT NULL,
    fecha datetime,
    PRIMARY KEY (id),
    FOREIGN KEY (id) REFERENCES usuario(id) ON DELETE CASCADE 

);

CREATE TABLE pelicula (
    id INT NOT NULL AUTO_INCREMENT,
    iduser INT NOT NULL,
    titulo VARCHAR(256) NOT NULL,
    text VARCHAR(256) NOT NULL,
    genero ENUM('Acción', 'Aventuras', 'Comedia', 'Drama', 'Ciencia_Ficción', 'Musical', 'Documental'),
    año DATE,
    src VARCHAR(256),
    numerototalLikes Int,
    PRIMARY KEY (id),
    FOREIGN KEY (iduser) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE comentario (
    id INT NOT NULL AUTO_INCREMENT,
    idpubli INT NOT NULL,
    iduser INT NOT NULL,
    text VARCHAR(256) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (idpubli) REFERENCES pelicula(id) ON DELETE CASCADE,
    FOREIGN KEY (iduser) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE amigo (
    iduser1 INT NOT NULL,
    iduser2 INT NOT NULL,
    PRIMARY KEY (iduser1, iduser2),
    FOREIGN KEY (iduser1) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (iduser2) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE mensaje (
    id INT NOT NULL AUTO_INCREMENT,
    iduser1 INT NOT NULL,
    iduser2 INT NOT NULL,
    Text VARCHAR(256),
    PRIMARY KEY (id),
    FOREIGN KEY (iduser1) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (iduser2) REFERENCES usuario(id) ON DELETE CASCADE
);

