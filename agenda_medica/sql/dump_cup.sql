SET FOREIGN_KEY_CHECKS=0;
TRUNCATE CUP;

INSERT INTO CUP (Codice,Password,CodiceASL) VALUES

	("CVICENZA00","cupvicenza",1),
	("CPADOVA01","cuppadova",2),
	("CVENEZIA02","cupvenezia",3),
	("CVERONA03","cupverona",4),
	("CBELLUNO04","cupbelluno",5),
	("CTREVISO05","cuptreviso",6),
	("CROVIGO06","cuprovigo",7),
	("CCHIOGGIA07","cupchioggia",8);

SET FOREIGN_KEY_CHECKS=1;