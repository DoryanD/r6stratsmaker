CREATE DATABASE IF NOT EXISTS r6stratsmakerdb;

USE r6stratsmakerdb;

CREATE TABLE IF NOT EXISTS accounts
(
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) UNIQUE KEY NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE KEY NOT NULL,
  activation_code VARCHAR(100) DEFAULT '123456' NOT NULL,
  recovery_code VARCHAR(100) DEFAULT '123456' NOT NULL,
  team_id VARCHAR(20) DEFAULT 'NONE',
  user_type VARCHAR(20) DEFAULT 'normalUser'
) ENGINE=InnoDb AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS teams
(
  team_id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  team_name VARCHAR(50) UNIQUE KEY NOT NULL,
  founderName VARCHAR(50) UNIQUE KEY NOT NULL,
  members int(11) DEFAULT 1 NOT NULL
) ENGINE=InnoDb AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO accounts (id, username, password, email, activation_code, recovery_code) VALUES (1, 'user1', '$2y$10$yI9jF5.ey22AwYPd2czSiefyl0PY8Pe.PPeT3An0NzqmNtPI3Tjua', 'mail@mail.com', '5d94b1ec8c0f2', '5d94b1ec8c0fa');
INSERT INTO accounts (id, username, password, email, activation_code, recovery_code) VALUES (2, 'user2', '$2y$10$yI9jF5.ey22AwYPd2czSiefyl0PY8Pe.PPeT3An0NzqmNtPI3Tjua', 'mail@mail2.com', 'activated', '5d94b1ec8c0fa');
