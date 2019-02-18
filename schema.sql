DROP DATABASE IF EXISTS doingsdone;
CREATE DATABASE doingsdone
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;
USE doingsdone;
CREATE TABLE users(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email CHAR(128) NOT NULL UNIQUE,
	password CHAR(64) NOT NULL,
	name CHAR(128) NOT NULL,
	date_registration TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE projects(
	id INT AUTO_INCREMENT PRIMARY KEY,
	name_project CHAR(128) 	NOT NULL,
	id_user INT NOT NULL
);
CREATE TABLE tasks(
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	completion_date TIMESTAMP,
	status BIT NOT NULL DEFAULT 0,
	title CHAR(255),
	file CHAR(255),
	deadline TIMESTAMP,
	id_project INT NOT NULL,
	id_user INT NOT NULL
);
