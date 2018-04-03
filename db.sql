DROP DATABASE IF EXISTS goFlexDb;
CREATE DATABASE goFlexDb;

USE goFlexDb;

CREATE TABLE tblRole (
	roleId INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE tblUser (
	userId INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_role INT NOT NULL DEFAULT 4,
    
	username VARCHAR(60) NOT NULL UNIQUE,
	password VARCHAR(240) NOT NULL,
    
	firstname VARCHAR(60),
	lastname VARCHAR(60),
	
	phone VARCHAR(15),
	email VARCHAR(100),
	
    CONSTRAINT FK_UserRole
    FOREIGN KEY (user_role)
    REFERENCES tblRole(roleId)   
);

CREATE TABLE tblGateway (
	gwId INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	gwUser_userId INT,
	gwMac VARCHAR(22) NOT NULL UNIQUE,

	CONSTRAINT FK_UserGw
	FOREIGN KEY (gwUser_userId)
	REFERENCES tblUser(userId)
);


INSERT INTO tblRole VALUES (1, 'admin'), (2, 'tech'), (3, 'customer_care'), (4, 'client');
INSERT INTO tblUser (user_role, username, password) VALUES
(1, 'admin', 'password'),
(2, 'technical', 'password'),
(3, 'customer_care', 'password');
INSERT INTO tblUser (username, password) VALUES
('luc.dufour', 'password'),
('hugo.mendes', 'password'),
('jeremie.etienne.norbert.vianin', 'password'),
('matthieu.dayer', 'password');