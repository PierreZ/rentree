USE rentree;

TRUNCATE TABLE eleve;

INSERT INTO eleve
	(email, nom, datenaissance, emailparent, nomparent, telparent)
	VALUES
	('duchmoll@isen.fr', 'Duchmoll', '1992-01-01', 'duchmoll@hotmail.fr', 'Duchmoll Senior', '0246810121')
;

INSERT INTO admin
	(id_admin, email, pw_hash)
	VALUES
	(1, 'foo@bar.baz', PASSWORD('quux'))
;

INSERT INTO promotion
	(id_promotion, nompromotion)
	VALUES
	(1, 'CIR3')
;

INSERT INTO document
	(id_document, fichier, id_promotion)
	VALUES
	(1, 'patate.pdf', NULL),
	(2, 'tomate.pdf', 1)
;
