import random

nomi_regioni = {
	'UMB' : 'Umbria', 
	'VDA' : 'Valle d Aosta', 
	'MAR' : 'Marche', 
	'BAS' : 'Basilicata', 
	'FVG' : 'Friuli Venezia Giulia', 
	'TOS' : 'Toscana', 
	'CAM' : 'Campania', 
	'PUG' : 'Puglia', 
	'PIE' : 'Piemonte', 
	'LOM' : 'Lombardia', 
	'SIC' : 'Sicilia', 
	'ABR' : 'Abruzzo', 
	'LIG' : 'Liguria', 
	'TAA' : 'Trentino Alto Adige', 
	'LAZ' : 'Lazio', 
	'CAL' : 'Calabria', 
	'VEN' : 'Veneto', 
	'SAR' : 'Sardegna', 
	'EMR' : 'Emilia Romagna', 
	'MOL' : 'Molise'
}

def get_nome_regione(sigla):
	return nomi_regioni[sigla]


# Open file

file = open('listacomuni.txt','r')

risultati = {}




def calcola():
	for line in file:

		args = line.split(';')
		regione = get_nome_regione(args[3])
		
		if regione == 'Veneto':
			citta = args[1]
			codice = args[6]
			risultati[citta] = codice
	
		



def get_citta_codice():
	calcola()
	k = random.choice(risultati.keys())
	return (k,risultati[k])
	
