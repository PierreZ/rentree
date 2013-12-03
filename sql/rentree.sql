-- Made by Corentin Delcourt
--     and Pierre Zemb

CREATE TABLE `eleve` (
	`email` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`nom` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`datenaissance` DATE  NOT NULL,
	`emailparent` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`telparent` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`nomparent` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	PRIMARY KEY (`e-mail`)
);

CREATE TABLE `document` (
	`fichier` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	`nompromotion` varchar(256) character set utf8 collate utf8_bin REFERENCES promotion(nompromotion),
	PRIMARY KEY (`fichier`)
);

CREATE TABLE `promotion` (
	`nompromotion` varchar(256) character set utf8 collate utf8_bin NOT NULL,
	PRIMARY KEY (`nompromotion`)
);
