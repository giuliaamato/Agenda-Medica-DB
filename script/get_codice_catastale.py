# -*- coding: latin-1 -*-
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



def get_citta_nascita():
	file = open('listacomuni.txt','r')
	a = []
	for line in file:
		args = line.split(';')
		a.append(args)
	i = random.randint(0,len(a))
	citta = a[i]
	return citta[1]


def calcola():
	file = open('listacomuni.txt','r')
	risultati = {}
	for line in file:
		
		args = line.split(';')
		regione = get_nome_regione(args[3])
		
		if regione == 'Veneto':
			citta = args[1]
			codice = args[6]
			provincia = args[2]
			risultati[citta] = (codice,provincia)
			

	return risultati
		



def get_citta_codice():
	risultati = calcola()
	k = random.choice(risultati.keys())
	cod = risultati[k][0]
	prov = risultati[k][1]
	return (k,cod,prov) # ritorna nome della città, codice catastale e provincia
	
