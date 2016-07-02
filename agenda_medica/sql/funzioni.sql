# Funzione che permette di calcolare quante visite mediche ha effettuato un certo infermiere
CREATE FUNCTION `Conta_Visite`(CF_infermiere VARCHAR(16)) 
RETURNS smallint(5) unsigned
BEGIN
DECLARE tot_visite SMALLINT UNSIGNED;
SELECT Count(*) into tot_visite
FROM VisitaMedica VM
WHERE VM.CFinfermiere = CF_infermiere AND VM.TipoPrenotazione = 1
GROUP BY VM.CFinfermiere;
RETURN tot_visite;
END

# La funzione dice se un dottore con un certo CF è disponibile in una certa ora
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `controlla_dottore`(`ora` TIME, `specializzazione` VARCHAR(30)) RETURNS varchar(16) CHARSET utf8mb4
	NO SQL
BEGIN

DECLARE Disponibilita BOOL;
DECLARE cf VARCHAR(16);
SELECT D.CodiceFiscale,D.Disponibile INTO cf, Disponibilita
FROM Dottore D
WHERE ora BETWEEN D.OraInizio AND D.OraFine
AND D.Specializzazione = specializzazione
LIMIT 1;
IF(Disponibilita=1)
THEN RETURN cf;
ELSE RETURN NULL;
END IF;
END$$
DELIMITER ;
