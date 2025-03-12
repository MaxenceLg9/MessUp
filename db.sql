DROP DATABASE IF EXISTS messup;

CREATE DATABASE IF NOT EXISTS messup;

USE messup;

CREATE TABLE users (
    idUser int PRIMARY KEY AUTO_INCREMENT,
    picture BINARY,
    username VARCHAR(50),
    password VARCHAR(60)
);

CREATE TABLE message (
    idMessage int PRIMARY KEY AUTO_INCREMENT,
    content VARCHAR(200) NOT NULL,
    time TIMESTAMP,
    idUser int,
    idSalle int NOT NULL,
    CONSTRAINT fk_idUser FOREIGN KEY (idUser) REFERENCES users(idUser)#, CONSTRAINT fk_idSalle FOREIGN KEY (idSalle) REFERENCES Salle(idSalle)
);