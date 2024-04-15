CREATE SCHEMA `online_notes` ;

CREATE TABLE `online_notes`.`users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `activation` char(32) DEFAULT NULL,
  `activation2` char(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `online_notes`.`notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `note` text,
  `time` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `online_notes`.`forgotpassword` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `key` char(32) DEFAULT NULL,
  `time` int DEFAULT NULL,
  `status` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `online_notes`.`rememberme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `authenticator1` char(20) DEFAULT NULL,
  `f2authenticator2` char(64) DEFAULT NULL,
  `user_id` int NOT NULL,
  `expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

INSERT INTO online_notes.users (username, email, password, activation) VALUES ('Test', 'test@test.test', '95ac6e06052a014fe26457e6008a9c2744bce00f80c545e60b8bff7bb1f24a5a', 'activated');