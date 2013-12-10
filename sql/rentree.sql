-- Made by Corentin Delcourt
--     and Pierre Zemb

CREATE DATABASE rentree CHARACTER SET utf8 collate utf8_bin;
USE rentree;

CREATE TABLE `eleve` (
	`id_eleve` int NOT NULL auto_increment,
	`email` varchar(256) NOT NULL,
	`nom` varchar(256) NOT NULL,
	`datenaissance` DATE NOT NULL,
	`emailparent` varchar(256) NOT NULL,
	`telparent` varchar(256) NOT NULL,
	`nomparent` varchar(256) NOT NULL,
	PRIMARY KEY (`id_eleve`)
);

CREATE TABLE `document` (
	`id_document` int NOT NULL auto_increment,
	`fichier` varchar(256) NOT NULL,
	`id_promotion` int REFERENCES promotion(id_promotion),
	PRIMARY KEY (`id_document`)
);

CREATE TABLE `promotion` (
	`id_promotion` int NOT NULL auto_increment,
	`nompromotion` varchar(256) NOT NULL,
	PRIMARY KEY (`id_promotion`)
);

CREATE TABLE `admin` (
	`id_admin` int NOT NULL AUTO_INCREMENT,
	`email` varchar(256) NOT NULL,
	`pw_hash` varchar(256) NOT NULL,
	PRIMARY KEY (`id_admin`)
);

CREATE TABLE `session` (
	`id_admin` int PRIMARY KEY REFERENCES admin(id_admin),
	`key` varchar(256) NOT NULL
);
