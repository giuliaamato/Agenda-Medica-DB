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
 	AND TipoPrenotazione=1
 END $$
DELIMITER;

# Trigger che controlla se un dottore è disponibile nell'ora dichiarata
# nella specifica di una visita quando questa viene inserita nel database
DELIMITER $$
DROP IF EXISTS TRIGGER controlla_orario $$
CREATE TRIGGER controlla_orario
 BEFORE INSERT ON VisitaMedica
 FOR EACH ROW
 BEGIN
 	IF NEW.Data > (SELECT Dottore.OraFine FROM Dottore 
 				   WHERE Dottore.CodiceFiscale=NEW.CFDottore)
 	THEN
 		signal sqlstate '45000' set message_text = 'Data oltre orario visite'
 END $$
 DELIMITER;

