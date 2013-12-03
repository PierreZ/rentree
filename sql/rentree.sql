-- Made by Corentin Delcourt
--     and Pierre Zemb

CREATE DATABASE rentree CHARACTER SET utf8 collate utf8_bin;
use rentree

CREATE TABLE `eleve` (
	`id` int NOT NULL auto_increment,
	`email` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`nom` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`datenaissance` DATE  NOT NULL,
	`emailparent` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`telparent` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`nomparent` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `document` (
	`id` int NOT NULL auto_increment,
	`fichier` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`nompromotion` varchar(256) character set utf8 collate utf8_bin REFERENCES promotion(nompromotion),
	PRIMARY KEY (`id`)
);

CREATE TABLE `promotion` (
	`id` int NOT NULL auto_increment,
	`nompromotion` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	PRIMARY KEY (`id`)
);
