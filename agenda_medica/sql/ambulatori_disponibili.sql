#
# VIEW NECESSARIA
# 
CREATE VIEW ambulatori_prenotati AS SELECT Ambulatorio.Nome, VisitaMedica.Data 
FROM Ambulatorio 
JOIN VisitaMedica 
ON Ambulatorio.Nome=VisitaMedica.NomeAmbulatorio 
WHERE VisitaMedica.TipoPrenotazione = 0;


#
# PROCEDURA CHE RESTITUISCE GLI AMBULATORI DISPONBILI IN UNA CERTA DATA E 
# DI UNA CERTA ASL
# 
DELIMITER $$
CREATE PROCEDURE ambulatori_disp(IN data_scelta DATE, IN ora_scelta TIME, IN cf_dottore VARCHAR(16))
BEGIN
DECLARE conta INTEGER;
CREATE TEMPORARY TABLE temp (nome VARCHAR(5));
INSERT INTO temp
SELECT ambulatori_prenotati.Nome
FROM ambulatori_prenotati 
JOIN Ambulatorio 
ON ambulatori_prenotati.Nome = Ambulatorio.Nome  
WHERE DATE_FORMAT(ambulatori_prenotati.Data,'%Y-%m-%d') = data_scelta
AND Ambulatorio.CodiceASL = 
(SELECT CodiceASL FROM Informazioni WHERE Informazioni.CodiceFiscale=cf_dottore)
AND DATE_FORMAT(ambulatori_prenotati.Data, "%T") 
BETWEEN OraInizio(cf_dottore)
AND OraFine(cf_dottore)
AND DATEDIFF(OraFine(cf_dottore),DATE_FORMAT(ambulatori_prenotati.Data,"%T")) > '00:30:00'
AND (DATEDIFF(DATE_FORMAT(ambulatori_prenotati.Data,"%T"),ora_scelta) > '00:30:00'
OR DATEDIFF(ora_scelta,DATE_FORMAT(ambulatori_prenotati.Data,"%T")) > '00:30:00');

SELECT COUNT(*) INTO conta FROM temp;

IF conta > 0 
THEN SELECT * FROM temp;
ELSE 
SELECT Ambulatorio.Nome 
FROM Ambulatorio WHERE Ambulatorio.CodiceASL=
(SELECT CodiceASL FROM Informazioni WHERE Informazioni.CodiceFiscale=cf_dottore) 
AND Ambulatorio.Nome 
NOT IN (SELECT VisitaMedica.NomeAmbulatorio 
FROM VisitaMedica WHERE VisitaMedica.TipoPrenotazione=0);
END IF;

END $$
DELIMITER;
