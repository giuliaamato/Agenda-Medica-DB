from get_values_pazienti import crea_valori

for i in range(1,10):

	paziente = crea_valori()

	print "paziente n."+str(i)

	print paziente["codice_fiscale"]
	print paziente["nome"]
	print paziente["cognome"]
	print paziente["sesso"]
	print paziente["d_nascita"] 
	print paziente["c_residenza"]
	print paziente["c_nascita"]
	print paziente["indirizzo"]
	print paziente["telefono"]
	print paziente["email"]

	print "------------------------"
	