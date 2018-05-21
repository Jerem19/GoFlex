DROP DATABASE IF EXISTS goFlexDb;
CREATE DATABASE goFlexDb;

USE goFlexDb;

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

CREATE TABLE tblPictures (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT    
);

CREATE TABLE tblManyPictures (
	_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    pic_pics INT,
    pic_pic INT,
    
    CONSTRAINT FK_pics
	FOREIGN KEY (pic_pics)
	REFERENCES tblPictures(_id),
    
    CONSTRAINT FK_pic
	FOREIGN KEY (pic_pic)
	REFERENCES tblPicture(_id)
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
    heatPictures INT,
    
    hotwaterEner INT DEFAULT 1,
    hotwaterTech INT DEFAULT 1,
    hotwaterSensors INT(2) DEFAULT 0,
    hotwaterTempSensors INT(2) DEFAULT 0,
    hotwaterNote TEXT,
    hotwaterPictures INT,
    
    solarPanel BOOLEAN DEFAULT FALSE,
    solarSensors INT(2) DEFAULT 0,
    solarNote TEXT DEFAULT NULL,
    
    city VARCHAR(100),
    npa VARCHAR(10),
    address VARCHAR(100),
        
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
        
    CONSTRAINT FK_picHeat
	FOREIGN KEY (heatPictures)
	REFERENCES tblPictures(_id),
    
    CONSTRAINT FK_picHot
	FOREIGN KEY (hotwaterPictures)
	REFERENCES tblPictures(_id),
    
    CONSTRAINT FK_picture
	FOREIGN KEY (picture)
	REFERENCES tblPicture(_id)
);


INSERT INTO tblRole VALUES (1, 'admin'), (2, 'technical'), (3, 'customer_care'), (4, 'client');
INSERT INTO tblStatus VALUES  (1, 'ready'), (2, 'ok'), (3, 'busy');

INSERT INTO tblUser (user_role, username, password, token, email, active) VALUES
(1, 'admin', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '409d565186e0385eacd12d059d1c6007369b0ab1a78fcdbe4608b87b23b6f9daf7d1b39706f4ab8ba4d38f89ac61646d696e', 'admin@go.flex', true),
(2, 'technical', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '1fe3e1dbea55b842ba8d29660df2bccedf8ce94066037b93e8d299def420c795b1f5ca15615ace896b746563686e6963616c', 'technical@go.flex', true),
(3, 'customer_care', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '2673517f79d47244a9d3eb962f2b4708bc85574b6d3de817940b29c238d857966176989022637573746f6d65725f63617265', 'info@go.flex', true),
(4, 'goFlex1', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '8b5e2b7fac8d84191f887852139e9864573f36b305e555e1ec205c8284ea73aeebf5db0604e749e57b2cd7676f466c657831', '1@go.flex', true),
(4, 'goFlex2', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '5e7ce4fe8c1672a93687d2d6f1a6def5394ede477de57c0e0e83fb0b12c82a16e0c291e7d64171257d7e47676f466c657832', '2@go.flex', true),
(4, 'goFlex3', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', 'aa53b69c2dd2a075ef00fe476fb4953ae1b70bc5d1dd9c86e3a9d6dcf86fd7c51d93a58ab1ce07712c03cb676f466c657833', '3@go.flex', true),
(4, 'noactive', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '5e7ce4fe8c1672a93687d2d6f1a6def5394ede477de57c150e83fb0b12c8er16e0c291e7d64171257d7e47676f466c657832', 'noactive@go.flex', false);
(4, 4, 'jessen.page', '$2y$13$aX/r/Pj8GchBdHf9UtL3XO4kNYB/nL201ZLYdbF7T7O2.izShAMYq', 'Jessen', 'Page', '1@go.flex', NULL, 1, '8b5e2b7fac8d84191f887852139e9864573f36b305e555e1ec205c8284ea73aeebf5db0604e749e57b2cd7676f466c657831', 0),
(5, 4, 'pierreandre.seppey', '$2y$13$d6Bn6maqP7E81POhriO48e5UqislALPiXwmS5Q4uCsMYZODeCpeNu', 'Pierre-André', 'Seppey', '2@go.flex', NULL, 1, '5e7ce4fe8c1672a93687d2d6f1a6def5394ede477de57c0e0e83fb0b12c82a16e0c291e7d64171257d7e47676f466c657832', 0),
(6, 4, 'gregory.clivaz', '$2y$14$05B6ymBUzpqAIoisEkKexexOKzcAPRpePaIrlndTGQ9LwuHiIvc.y', 'Gregory', 'Clivaz', '3@go.flex', NULL, 1, 'aa53b69c2dd2a075ef00fe476fb4953ae1b70bc5d1dd9c86e3a9d6dcf86fd7c51d93a58ab1ce07712c03cb676f466c657833', 0),


INSERT INTO tblGateway (name) VALUES
('goflex-dc-001'), ('goflex-dc-002'), ('goflex-dc-003');

INSERT INTO tblBuisSector (name) VALUES ('residential'), ('industrial'), ('tertiary');
INSERT INTO tblEnergy (name) VALUES ('electricity'), ('wood'), ('gaz');
INSERT INTO tblTechnology (name) VALUES ('heat_pump'), ('boiler'), ('wood_burner');

INSERT INTO tblInstallation (inst_userId, inst_gwId) VALUES
(4, 1), (5, 2), (6, 3);