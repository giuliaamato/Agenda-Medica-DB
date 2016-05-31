SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE Informazioni;
INSERT INTO Informazioni(CodiceFiscale,DataNascita,Nome,Cognome,Email,Sesso,Telefono,CittaResidenza,CittaNascita,Indirizzo,CodiceASL) VALUES 
('BRTSST61L27B196I','1961/7/27','Sisto','Bertelli','sistobertelli41@yahoo.it','M','0444800458','Brogliano','Miglionico','vicolo del Vento',1),
('DDDFRN73P68F957J','1973/9/28','Francesca','Daddario','francescadaddario79@gmail.com','F','0444952884','Nove','Cisterna d''Asti','via Bergamasco',8),
('NNNTDD55S17A061B','1955/11/17','Taddeo','Nenni','taddeonenni78@yahoo.it','M','045750312','Affi','Strongoli','via Vito Rapisardi',4),
('BLTSML50P06H280U','1950/9/6','Samuele','Bialetti','samuelebialetti86@yahoo.it','M','0422883900','Riese Pio X','Roccapalumba','viale Francia',5),
('FLRLCU72T56F394H','1972/12/16','Lucia','Falerno','luciafalerno38@gmail.com','F','049618999','Montagnana','San Costanzo','via Castelmenardo',2),
('FRNTRQ89D11C630U','1989/4/11','Torquato','Farno','torquatofarno44@aruba.it','M','0437420008','Chies d''Alpago','Petrella Tifernina','Viale Trento e Trieste',3),
('BGHTDD86M26G875B','1986/8/26','Taddeo','Baghi','taddeobaghi77@libero.it','M','0422572819','Ponzano Veneto','Labro','Via XIV Maggio',6),
('ADNNDA77A42L985B','1977/1/2','Nadia','Adone','nadiaadone15@libero.it','F','0425782198','Villanova del Ghebbo','Saltara','via G. Ghirlanda',7);
SET FOREIGN_KEY_CHECKS = 1;