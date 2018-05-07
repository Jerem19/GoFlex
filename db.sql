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


INSERT INTO tblRole VALUES (1, 'admin'), (2, 'technical'), (3, 'customer_care'), (4, 'client');
INSERT INTO tblStatus VALUES (1, 'stock'), (2, 'ready'), (3, 'ok'), (4, 'busy');
INSERT INTO tblUser (user_role, username, password, token, email, active) VALUES
(1, 'admin', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '409d565186e0385eacd12d059d1c6007369b0ab1a78fcdbe4608b87b23b6f9daf7d1b39706f4ab8ba4d38f89ac61646d696e', 'admin@go.flex', true),
(2, 'technical', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '1fe3e1dbea55b842ba8d29660df2bccedf8ce94066037b93e8d299def420c795b1f5ca15615ace896b746563686e6963616c', 'technical@go.flex', true),
(3, 'customer_care', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '2673517f79d47244a9d3eb962f2b4708bc85574b6d3de817940b29c238d857966176989022637573746f6d65725f63617265', 'info@go.flex', true),
(4, 'goFlex1', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '8b5e2b7fac8d84191f887852139e9864573f36b305e555e1ec205c8284ea73aeebf5db0604e749e57b2cd7676f466c657831', '1@go.flex', true),
(4, 'goFlex2', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '5e7ce4fe8c1672a93687d2d6f1a6def5394ede477de57c0e0e83fb0b12c82a16e0c291e7d64171257d7e47676f466c657832', '2@go.flex', true),
(4, 'goFlex3', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', 'aa53b69c2dd2a075ef00fe476fb4953ae1b70bc5d1dd9c86e3a9d6dcf86fd7c51d93a58ab1ce07712c03cb676f466c657833', '3@go.flex', true),
(4, 'noactive', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '5e7ce4fe8c1672a93687d2d6f1a6def5394ede477de57c150e83fb0b12c8er16e0c291e7d64171257d7e47676f466c657832', '2@go.flex', false);
/*('luc.dufour', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '52fded9d242d0eb6656e388fae8c27fccf8b23fe6068631bda073688d03c9737e2e9621a5a4392326c75632e6475666f7572', ''),
('hugo.mendes', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', 'b8412836102fd2d6bded57828e8a0e9aae613df15358de51bc6719d28e99f061f7a8b9668a181c6875676f2e6d656e646573', ''),
('jeremie.etienne.norbert.vianin', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', '3358c2a5e2354e2dec1c8aa1e373a30294468fa26a6572656d69652e657469656e6e652e6e6f72626572742e7669616e696e', ''),
('matthieu.dayer', '$2y$12$1IXJt84dRbEw0v6OIpNVRuH6cXJPbOS.IYoccc3hCYFu9ZXqdePgS', 'f54ad3ac2fbc401d62fdb85106d92de107bb309fae66e6c6f3044d72f3ae8e75e7e1f0ef6d617474686965752e6461796572', ''),
*/

INSERT INTO tblGateway (mac, name) VALUES 
('00:00:00:00:01', 'goflex-dc-001'),
('00:00:00:00:02', 'goflex-dc-002'),
('00:00:00:00:03', 'goflex-dc-003'),
('00:00:00:00:04', 'goflex-dc-003 2');
INSERT INTO tblInstallation (inst_userId, inst_gwId) VALUES (4, 1), (5, 2), (6, 3), (6, 4);