SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE ASL;

INSERT INTO ASL (Indirizzo,Email,Telefono,CittaSede) VALUES

	("Via Mazzini 1","veneto1@asl.it","0444420601","Vicenza"),
	("Via Pascoli 13","veneto2@asl.it","0492135674","Padova"),
	("Castello 6613","veneto3@asl.it","0415200552","Venezia"),
	("Viale Valverde 42","veneto4@asl.it","0458075511","Verona"),
	("Viale Europa 22","veneto5@asl.it","0437516111","Belluno"),
	("P.zza Ospedale 1","veneto6@asl.it","0422322111","Treviso"),
	("Viale Tre Martiri 89","veneto7@asl.it","04253931","Rovigo"),
	("Viale Vespucci 12","veneto8@asl.it","0415572211","Chioggia");

SET FOREIGN_KEY_CHECKS = 1;