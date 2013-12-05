-- Made by Corentin Delcourt
--     and Pierre Zemb

CREATE DATABASE rentree CHARACTER SET utf8 collate utf8_bin;
use rentree

CREATE TABLE `eleve` (
	`id` int NOT NULL auto_increment,
	`email` varchar(256) NOT NULL,
	`nom` varchar(256) NOT NULL,
	`datenaissance` DATE NOT NULL,
	`emailparent` varchar(256) NOT NULL,
	`telparent` varchar(256) NOT NULL,
	`nomparent` varchar(256) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `document` (
	`id` int NOT NULL auto_increment,
	`fichier` varchar(256) NOT NULL,
	`nompromotion` varchar(256) REFERENCES promotion(nompromotion),
	PRIMARY KEY (`id`)
);

CREATE TABLE `promotion` (
	`id` int NOT NULL auto_increment,
	`nompromotion` varchar(256) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `admin` (
	`admin_id` int NOT NULL AUTO_INCREMENT,
	`email` varchar(256) NOT NULL,
	`pw_hash` varchar(256) NOT NULL
);

CREATE TABLE `session` (
	`admin_id` int PRIMARY KEY REFERENCES admin(admin_id),
	`key` varchar(256) NOT NULL
);
