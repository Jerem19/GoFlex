DROP DATABASE IF EXISTS goflex_clients;
CREATE DATABASE goflex_clients;

USE goflex_clients;

CREATE TABLE tblRole (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE tblUser (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
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
    REFERENCES tblRole(_id)   
);

CREATE TABLE tblStatus (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(25) # name matches l10N
);

CREATE TABLE tblGateway (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	gw_status INT NOT NULL DEFAULT 1,
	name VARCHAR(45) UNIQUE,
    
    CONSTRAINT FK_StatGWay
	FOREIGN KEY (gw_status)
	REFERENCES tblStatus(_id)
);

CREATE TABLE tblBuisSector(
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(45)
);

CREATE TABLE tblEnergy (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(45)
);

CREATE TABLE tblTechnology (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(45)
);

CREATE TABLE tblPicture (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(50)
);

CREATE TABLE tblInstallation (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	inst_userId INT,
    inst_gwId INT UNIQUE,
    
    facturation BOOLEAN NOT NULL DEFAULT TRUE, # true < 100MWh
    businessSector INT DEFAULT 1,
    
    heatEner INT DEFAULT 1,
    heatTech INT DEFAULT 1,
    heatSensors INT(2) DEFAULT 0,
    heatTempSensors INT(2) DEFAULT 0,
    heatNote TEXT,
    heatPictures VARCHAR(100),
    
    hotwaterEner INT DEFAULT 1,
    hotwaterTech INT DEFAULT 1,
    hotwaterSensors INT(2) DEFAULT 0,
    hotwaterTempSensors INT(2) DEFAULT 0,
    hotwaterNote TEXT,
    hotwaterPictures VARCHAR(100),
    
    solarPanel BOOLEAN DEFAULT FALSE,
    solarSensors INT(2) DEFAULT 0,
    solarNote TEXT DEFAULT NULL,
    
    city VARCHAR(100),
    npa VARCHAR(10),
    address VARCHAR(100),
    
    noteAdmin TEXT DEFAULT NULL,
    note TEXT DEFAULT NULL,
    picture INT,

	CONSTRAINT FK_UserSet
	FOREIGN KEY (inst_userId)
	REFERENCES tblUser(_id),
        
	CONSTRAINT FK_GWaySet
	FOREIGN KEY (inst_gwId)
	REFERENCES tblGateway(_id),
    
    CONSTRAINT FK_BuisSect
	FOREIGN KEY (businessSector)
	REFERENCES tblBuisSector(_id),
    
    CONSTRAINT FK_heatEner
	FOREIGN KEY (heatEner)
	REFERENCES tblEnergy(_id),
    
    CONSTRAINT FK_heatTech
	FOREIGN KEY (heatTech)
	REFERENCES tblTechnology(_id),
    
    CONSTRAINT FK_hotEner
	FOREIGN KEY (hotwaterEner)
	REFERENCES tblEnergy(_id),
    
    CONSTRAINT FK_hotTech
	FOREIGN KEY (hotwaterTech)
	REFERENCES tblTechnology(_id),
    
    CONSTRAINT FK_picture
	FOREIGN KEY (picture)
	REFERENCES tblPicture(_id)
);


INSERT INTO tblRole VALUES (1, 'admin'), (2, 'technical'), (3, 'customer_care'), (4, 'client');
INSERT INTO tblStatus VALUES  (1, 'ready'), (2, 'ok'), (3, 'busy');

INSERT INTO tblUser (user_role, username, password, token, email, active) VALUES
(1, 'admin', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '409d565186e0385eacd12d059d1c6007369b0ab1a78fcdbe4608b87b23b6f9daf7d1b39706f4ab8ba4d38f89ac61646d696e', 'admin@go.flex', true),
(2, 'technical', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '1fe3e1dbea55b842ba8d29660df2bccedf8ce94066037b93e8d299def420c795b1f5ca15615ace896b746563686e6963616c', 'technical@go.flex', true),
(3, 'customer_care', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '2673517f79d47244a9d3eb962f2b4708bc85574b6d3de817940b29c238d857966176989022637573746f6d65725f63617265', 'info@go.flex', true);

INSERT INTO tblBuisSector (name) VALUES ('residential'), ('industrial'), ('tertiary');
INSERT INTO tblEnergy (name) VALUES ('electricity'), ('wood'), ('gaz');
INSERT INTO tblTechnology (name) VALUES ('heat_pump'), ('boiler'), ('wood_burner');