SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE VisitaMedica;
INSERT INTO VisitaMedica(CodiceVisita, Data, Ambulatorio, TipoVisita, TipoPrenotazione, Priorita, CFdottore, CFinfermiere, CFpaziente, CodiceReferto) VALUES
(1, '2016-03-10 14:45:00', 'Pronto Soccorso', 'Visita', 'Effettuata','M','MTRMTT63D19D118Q', 'NVNGLI87R41C383T', 'NGRALB80D24B578M', 1),
(2, '2016-03-11 09:45:00', 'Ortopedia', 'Visita', 'Effettuata', 'L', 'OTTGSP69E21H220D', 'MTRQNT77H05B154Y', 'DMCRGN75H70L026P', 2),
(4, '2016-6-10 10:55:00', 'Dermatologia', 'Controllo', 'Prenotata', 'L', 'ANGORZ44D30D107M', NULL, 'ORLGVN83E03D506A', 3);
SET FOREIGN_KEY_CHECKS = 1;