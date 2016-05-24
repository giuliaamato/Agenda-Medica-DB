SET FOREIGN_KEY_CHECKS=0;
TRUNCATE CUP;

INSERT INTO CUP (Codice,Password,CodiceASL) VALUES

	("CVICENZA00","cupvicenza",0),
	("CPADOVA01","cuppadova",1),
	("CVENEZIA02","cupvenezia",2),
	("CVERONA03","cupverona",3),
	("CBELLUNO04","cupbelluno",4),
	("CTREVISO05","cuptreviso",5),
	("CROVIGO06","cuprovigo",6),
	("CCHIOGGIA07","cupchioggia",7);

SET FOREIGN_KEY_CHECKS=1;