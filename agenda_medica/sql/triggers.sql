# Quando un dottore viene cancellato dal database, 
# per ogni visita effettuata modificare “CF Dottore” mettendolo a NULL. 
# Se la visita è di tipo “prenotata” bisogna assegnare la visita ad un 
# dottore disponibile in quella data e con la specializzazione adatta.
DELIMITER $$
DROP IF EXISTS TRIGGER controlla_visita $$
CREATE TRIGGER controlla_visita
 BEFORE DELETE ON Dottore
 FOR EACH ROW
 BEGIN
 	UPDATE VisitaMedica
 	SET VisitaMedica.CFDottore = $chiama_procedura($row)
 	WHERE VisitaMedica.CFDottore = OLD.CodiceFiscale;
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
 	# controlla se il dottore è disponibile
 END $$
 DELIMITER;

