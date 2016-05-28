# -*- coding: latin-1 -*-
from get_values_pazienti import crea_valori

output = open('dump_informazioni2.sql','w')

output.write("SET FOREIGN_KEY_CHECKS = 0;\n")
output.write("TRUNCATE Citta;\n")
output.write("INSERT INTO Informazioni(CodiceFiscale,DataNascita,Nome,Cognome,Email,Sesso,Telefono,CittaResidenza,CittaNascita,Indirizzo,CodiceASL) VALUES \n")

for i in range(1,100):

	paziente = crea_valori()

	print "paziente n."+str(i)
	print paziente 
	output.write("("+"'"+paziente["codice_fiscale"]+"'"+","+"'"+paziente["d_nascita"]+"'"+","+"'"+paziente["nome"]+"'"+","+"'"+paziente["cognome"]+"'"+","+"'"+paziente["email"]+"'"+","+"'"+paziente["telefono"]+"'"+","+"'"+paziente["c_residenza"]+"'"+","+"'"+paziente["c_nascita"]+"'"+","+"'"+paziente["indirizzo"]+"'"+","+"'"+"'"+"),\n")

output.write(";\n")
output.write("SET FOREIGN_KEY_CHECKS = 1;")