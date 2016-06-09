#
# Ritorna i dottori che nel mese precedente hanno effettuato meno di 2 visite mediche
#
SELECT COUNT(*), VisitaMedica.CFDottore FROM VisitaMedica 
JOIN Informazioni ON Informazioni.CodiceFiscale = VisitaMedica.CFDottore 
WHERE CodiceASL=2 AND TipoPrenotazione=0 AND EXTRACT(YEAR FROM VisitaMedica.Data)=EXTRACT(YEAR 
FROM DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) AND EXTRACT(MONTH FROM VisitaMedica.Data)=EXTRACT(MONTH 
FROM DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) GROUP BY CFDottore
HAVING COUNT(*)<2;

#
# Ottenere i dati degli infermieri tirocinanti che nel mese precedente non hanno 
# eseguito almeno 5 visite
#
SELECT T1.CodiceFiscale FROM (SELECT Informazioni.CodiceFiscale 
FROM Informazioni JOIN Infermiere ON Informazioni.CodiceFiscale=Infermiere.CodiceFiscale 
WHERE Informazioni.CodiceASL=3 AND Infermiere.Tirocinante=1) T1 
INNER JOIN VisitaMedica ON T1.CodiceFiscale=VisitaMedica.CFInfermiere 
WHERE EXTRACT(YEAR FROM VisitaMedica.Data)=EXTRACT(YEAR 
FROM DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) 
AND EXTRACT(MONTH FROM VisitaMedica.Data)=EXTRACT(MONTH 
FROM DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) GROUP BY CFInfermiere
HAVING COUNT(*)<5;

#
# Ottenere codice ASL che ha il minor numero di infermieri tirocinanti oppure inserire 
# nella ASL di afferenza dell’admin (si attiva un trigger che abbassa gli stipendi dei tirocinanti)
#
SELECT MIN(T1.CountInf),T1.CodiceASL 
FROM (SELECT COUNT(Infermiere.CodiceFiscale) 
AS CountInf,Informazioni.CodiceASL FROM Infermiere 
JOIN Informazioni ON Infermiere.CodiceFiscale=Informazioni.CodiceFiscale 
WHERE Infermiere.Tirocinante=1 GROUP BY Informazioni.CodiceASL) T1