# Quando un dottore viene cancellato dal database, 
# per ogni visita effettuata modificare “CF Dottore” mettendolo a NULL. 
# Se la visita è di tipo prenotata è necessario invece cancellarla dal database.
DELIMITER $$
DROP IF EXISTS TRIGGER controlla_visita $$
CREATE TRIGGER controlla_visita
 BEFORE DELETE ON Dottore
 FOR EACH ROW
 BEGIN
 	DELETE FROM VisitaMedica 
 	WHERE CFDottore=OLD.CodiceFiscale 
 	AND TipoPrenotazione=0
 END $$
DELIMITER;

# Quando una visita medica diventa di tipo "effettuata"(tipoPrenotazione = 1)
# allora controlla il numero di visite a cui a partecipato l'infermiere (se c'è)
# e se questo numero è uguale a 4 allora aumenta di 200 lo stipendio.
DELIMITER $$
DROP IF EXISTS TRIGGER premio_infermiere $$
CREATE TRIGGER premio_infermiere
BEFORE UPDATE ON VisitaMedica
FOR EACH ROW
BEGIN
	IF conta_visite(OLD.CFInfermiere) = 4
	THEN 
	UPDATE Infermiere
	SET Infermiere.Stipendio = Infermiere.Stipendio+200
	WHERE Infermiere.CodiceFiscale=OLD.CFInfermiere;
	END IF;
END $$
DELIMITER;