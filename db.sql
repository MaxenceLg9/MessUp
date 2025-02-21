DROP DATABASE IF EXISTS messup;

CREATE DATABASE IF NOT EXISTS messup;

USE messup;

CREATE TABLE message(
    idMessage int PRIMARY KEY AUTO_INCREMENT,
    content VARCHAR(200) NOT NULL,
    time TIMESTAMP,
    author VARCHAR(200),
    idSalle int NOT NULL
);