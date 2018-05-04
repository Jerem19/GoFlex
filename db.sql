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
    
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(240) NOT NULL,
    
	firstname VARCHAR(60),
	lastname VARCHAR(60),	
	email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
	
	active BOOLEAN DEFAULT FALSE,
    token VARCHAR(100) UNIQUE,    
    count INT DEFAULT 0,
    
    CONSTRAINT FK_UserRole
    FOREIGN KEY (user_role)
    REFERENCES tblRole(roleId)   
);

CREATE TABLE tblStatus (
	statusId INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(25) # name matches l10N
);

CREATE TABLE tblGateway (
	gatewayId INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    gw_status INT NOT NULL DEFAULT 1,
    name VARCHAR(45),
	mac VARCHAR(22) NOT NULL UNIQUE,
    
    CONSTRAINT FK_StatGWay
	FOREIGN KEY (gw_status)
	REFERENCES tblStatus(statusId)
);

CREATE TABLE tblInstallation (
	installationId INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	inst_userId INT,
    inst_gwId INT UNIQUE,

	CONSTRAINT FK_UserSet
	FOREIGN KEY (inst_userId)
	REFERENCES tblUser(userId),
        
	CONSTRAINT FK_GWaySet
	FOREIGN KEY (inst_gwId)
	REFERENCES tblGateway(gatewayId)
);


INSERT INTO tblRole VALUES (1, 'admin'), (2, 'tech'), (3, 'customer_care'), (4, 'client');
INSERT INTO tblStatus VALUES (1, 'stock'), (2, 'ready'), (3, 'ok'), (4, 'busy');
INSERT INTO tblUser (user_role, username, password, email) VALUES 
(1, 'admin', 'password', ''), (2, 'technical', 'password', ''), (3, 'customer_care', 'password', '');
INSERT INTO tblUser (username, password, email) VALUES
('luc.dufour', 'password', ''), ('hugo.mendes', 'password', ''),
('jeremie.etienne.norbert.vianin', 'password', ''), ('matthieu.dayer', 'password', ''),
('goFlex1', 'password', ''), ('goFlex2', 'password', ''), ('goFlex3', 'password', '');

INSERT INTO tblGateway (mac, name) VALUES 
('00:00:00:00:01', 'goflex-dc-001'),
('00:00:00:00:02', 'goflex-dc-002'),
('00:00:00:00:03', 'goflex-dc-003'),
('00:00:00:00:04', 'goflex-dc-003 2');
INSERT INTO tblInstallation (inst_userId, inst_gwId) VALUES (8, 1), (9, 2), (10, 3), (10, 4);