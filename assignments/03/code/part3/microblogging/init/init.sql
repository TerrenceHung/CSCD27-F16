DROP DATABASE IF EXISTS microblogging;

CREATE DATABASE microblogging;

USE microblogging;

CREATE TABLE users (
    email VARCHAR(255) NOT NULL PRIMARY KEY,
    name VARCHAR(255),
    password VARCHAR(255)
);

CREATE TABLE posts (
     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
     msg TEXT,
     owner VARCHAR(255) NOT NULL REFERENCES users(email)
);

CREATE TABLE profiles (
     url TEXT,
     owner VARCHAR(255) NOT NULL PRIMARY KEY REFERENCES users(email)
);

GRANT FILE ON *.* TO 'root'@'localhost';

