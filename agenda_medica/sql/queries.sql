# Query che permette di ottenere il massimo numero di visite 
# mediche effettuate da un infermiere tirocinante,
# il massimo numero di visite mediche effettuate da un dottore, 
# in cui la priorità delle visite e’ al livello minore (L), 
# e il massimo numero di visite mediche effettuate da un dottore, 
# in cui la priorità delle visite e’ al livello maggiore (H) 
SELECT MAX(VisiteEffettuate) 
FROM (SELECT VM.CFinfermiere, VM.CFdottore, COUNT(*) VisiteEffettuate 
FROM Infermiere i, VisitaMedica VM 
WHERE i.Tirocinante = 1 AND VM.CFinfermiere = i.CodiceFiscale 
GROUP BY VM.CFinfermiere, VM.CFdottore ) AS T 
UNION SELECT MAX(VisiteEffettuate) 
FROM (SELECT VM.CFdottore, COUNT(*) VisiteEffettuate 
FROM VisitaMedica VM WHERE VM.TipoPrenotazione = 1 
AND VM.Priorita = 'L' GROUP BY VM.CFdottore ) AS T2 
UNION SELECT MAX(VisiteEffettuate) FROM 
(SELECT VM.CFdottore, COUNT(*) VisiteEffettuate FROM VisitaMedica VM 
WHERE VM.TipoPrenotazione = 1 AND VM.Priorita = 'H' GROUP BY VM.CFdottore ) AS T3


# Query che, dati i codici fiscali dei dottori che non hanno mai fatto 
# nessuna visita medica, mostra il nome utente, 
# il codice fiscale e lo stipendio di questi dottori, 
# selezionando coloro che hanno la data scadenza dell’account 
# tra il 1 Gennaio 2016 e il 1 Ottobre 2016, il cui stipendio e’ 
# maggiore di 3000, il nome utente comprende una ca_ 
# (con _ si intente un qualsiasi carattere), e con l’orario di 
# inizio del turno del lavoro compreso tra le 9 e le 13, 
# e il turno di fine compreso tra le 13 e le 15.45
SELECT D.NomeUtente, D.CodiceFiscale, Doct.Stipendio
FROM DatiAccesso D JOIN Dottore Doct
ON D.CodiceFiscale = Doct.CodiceFiscale AND D.DataScadenza BETWEEN "2016-01-01" AND "2016-10-01"
AND Doct.Stipendio>3000 AND D.NomeUtente LIKE "%ca_%" AND Doct.OraInizio BETWEEN "9:00:00" AND "13:30:00"
AND Doct.OraFine BETWEEN "13:00:00" AND "15:45:00" AND Doct.CodiceFiscale 
NOT IN (SELECT VM.CFDottore FROM VisitaMedica VM, Informazioni I 
WHERE VM.CFdottore=I.CodiceFiscale)




#  Query che restituisce il codice fiscale dei dottori, il nome, il cognome e, 
#  per ogni dottore presente nel base dati, a prescindere dunque delle ASL 
#  di appartenenza, conta il numero di visite mediche effettuate 
#  nel mese di Luglio 2016
SELECT VM.CFdottore, I.Nome, I.Cognome, COUNT(VM.CFdottore) Visite_Effettuate 
FROM VisitaMedica VM JOIN Informazioni I ON VM.CFdottore = I.CodiceFiscale 
WHERE VM.CFdottore IN ( SELECT VM.CFdottore FROM VisitaMedica VM WHERE VM.TipoPrenotazione = 1 
AND VM.Data BETWEEN '2016-05-01 00:00:00' AND '2016-05-31 23:59:59') 
GROUP BY VM.CFdottore


# Query che permette di ottenere il codice della ASL che ha il maggior numero di 
# infermieri tirocinanti uomini nati in una data posteriore al 1 Gennaio 1970, 
# e di ottenere il codice della ASL con il maggior numero di infermiere tirocinanti 
# donne, nate anch’esse in una data posteriore a quella già espressa
SELECT MAX(T1.CountInf) Num_Tirocinanti  FROM (SELECT COUNT(Infermiere.CodiceFiscale) 
AS CountInf,Informazioni.CodiceASL FROM Infermiere JOIN Informazioni 
ON Infermiere.CodiceFiscale=Informazioni.CodiceFiscale WHERE Infermiere.Tirocinante=1 
AND CAST(Informazioni.DataNascita as date)>1970-01-01 AND Informazioni.Sesso='M' 
GROUP BY Informazioni.CodiceASL) T1 UNION SELECT MAX(T2.CountInf) Num_Tirocinanti 
FROM (SELECT COUNT(Infermiere.CodiceFiscale) AS CountInf,Informazioni.CodiceASL 
FROM Infermiere JOIN Informazioni ON Infermiere.CodiceFiscale=Informazioni.CodiceFiscale 
WHERE Infermiere.Tirocinante=1 AND CAST(Informazioni.DataNascita as date)>1970-01-01 
AND Informazioni.Sesso='F' GROUP BY Informazioni.CodiceASL) T2


# Query che restituisce nome, cognome, codice dell’ASL di 
# appartenenza e numero di visite effettuate dei dottori che nel 
# mese precedente hanno effettuato meno di 5 visite mediche
SELECT DISTINCT Informazioni.Nome, Informazioni.Cognome, Informazioni.CodiceASL, 
Informazioni.CodiceFiscale, COUNT(*) NumeroVisite FROM VisitaMedica JOIN Informazioni 
ON Informazioni.CodiceFiscale = VisitaMedica.CFDottore WHERE TipoPrenotazione=1 
AND EXTRACT(YEAR FROM VisitaMedica.Data)=EXTRACT(YEAR FROM DATE_SUB(CURDATE(),INTERVAL 1 MONTH))
AND EXTRACT(MONTH FROM VisitaMedica.Data)=EXTRACT(MONTH FROM DATE_SUB(CURDATE(),INTERVAL 1 MONTH)) 
GROUP BY CFDottore HAVING COUNT(*)<5



# Query che rende possibile ordinare le visite mediche ancora da 
# effettuare per anzianità, mostrando il nome e il cognome del paziente, 
# ma anche la data di nascita e il codice fiscale. 
# Avremo a disposizione anche le informazioni relative alla 
# visita medica prenotata, mostrano il nome dell’ambulatorio in cui verra’ 
# eseguita la visita, il tipo di visita, i codici fiscali dei dottori 
# e degli infermieri
SELECT I.Nome, I.Cognome, I.DataNascita, VM.CFPaziente, I.CodiceASL, VM.CodiceVisita, 
VM.Data, VM.NomeAmbulatorio, VM.TipoVisita, VM.Priorita, VM.CFDottore, VM.CFInfermiere, 
VM.CodiceReferto FROM VisitaMedica VM  JOIN Informazioni I 
WHERE VM.CFpaziente = I.CodiceFiscale AND VM.TipoPrenotazione = 0 
ORDER BY I.DataNascita




