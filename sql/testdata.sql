USE rentree;

TRUNCATE TABLE eleve;

INSERT INTO eleve
	(email, nom, datenaissance, emailparent, nomparent, telparent)
	VALUES
	('duchmoll@isen.fr', 'Duchmoll', '1992-01-01', 'duchmoll@hotmail.fr', 'Duchmoll Senior', '0246810121'),
	('duchmoll2@isen.fr', 'Duchmoll deux le retour', '1993-01-01', 'duchmoll@hotmail.fr', 'Duchmoll Senior', '0246810121'),
	('duchmoll3@isen.fr', 'Duchmoll trois la vengeance', '1994-01-01', 'duchmoll@hotmail.fr', 'Duchmoll Senior', '0246810121')
;

TRUNCATE TABLE admin;

INSERT INTO admin
	(id_admin, email, pw_hash)
	VALUES
	(1, 'foo@bar.baz', PASSWORD('quux'))
;

TRUNCATE TABLE promotion;

INSERT INTO promotion
	(id_promotion, nompromotion)
	VALUES
	(1, 'CIR3')
;

TRUNCATE TABLE document;

INSERT INTO document
	(id_document, fichier, id_promotion)
	VALUES
	(1, 'patate.pdf', NULL),
	(2, 'tomate.pdf', 1)
;
