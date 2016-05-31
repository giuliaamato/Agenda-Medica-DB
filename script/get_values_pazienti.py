# -*- coding: latin-1 -*-
from lxml import html
import requests
import random
from nomi import MASCHI, FEMMINE
from citta_comuni import get_citta_codice,get_citta_nascita
from control_char import controllo
from email_gen import get_email
from tel_gen import get_telefono
from gen_indirizzo import get_indirizzo


COGNOMI = [

	'Adone',
	'Baghi',
	'Farno',
	'Falerno',
	'Bialetti',
	'Nenni',
	'Daddario',
	'Bertelli'
]



MESI = {
	
	1: 'A',
	2: 'B',
	3: 'C',
	4: 'D',
	5: 'E',
	6: 'H',
	7: 'L',
	8: 'M',
	9: 'P',
	10: 'R',
	11: 'S',
	12: 'T',
	
}

SESSO = ['M','F']

def get_giorno(giorno,sesso):
	g = int(giorno)
	result = ""
	if sesso == SESSO[1]: # femmina
		g += 40 
	if g <= 9:
		result = "0"+str(g)
	else:
		result = str(g)

	return result


def get_mese(m):
	return MESI[int(m)]


def data():
	giorno = random.randint(1,30)
	mese = random.randint(1,12)
	anno = random.randint(1920,2016)
	return (giorno,mese,anno)

def nome():
	i = random.randint(1,2)
	if i == 1:
		r = random.randint(1,len(MASCHI)-1)
		return (MASCHI[r],SESSO[0])
	else:
		r = random.randint(1,len(FEMMINE)-1)
		return (FEMMINE[r],SESSO[1])

def sanitize_string(s):
	return s.replace("'","''")
	

def sanitize_cf(s):
	return s.replace(" ","")



def cognome():
	c = COGNOMI.pop()
	c = c.lower().capitalize()
	c = sanitize_string(c)
	# print c
	return c


def del_vowels(s):
	s = s.replace("'","")
	s = s.replace(" ","")
	v = ['a','e','i','o','u']
	cs = [] 
	for c in s:
		if c in v:
			s = s.replace(c,'')
			cs.append(c)
	i = 0
	while len(s) < 3:
		s += cs[i]	
		i+=1

	if len(s) > 3:
		s = s[:3]

	return s


def codice_fiscale(nome,cognome,data,sesso,citta_codice):

	nome = del_vowels(nome)
	cognome = del_vowels(cognome)
	cognome = sanitize_cf(cognome)
	nascita_anno = str(data[2])[-2:]
	nascita_mese = get_mese(data[1])
	nascita_giorno = get_giorno(data[0],sesso)
	codice_catastale = citta_codice[1]
	cf = cognome+nome+nascita_anno+nascita_mese+nascita_giorno+codice_catastale
	cf += controllo(cf)
	return cf.upper()

def crea_valori():
	valori = {}
	nome_sesso = nome() # tupla (nome,sesso)
	n = nome_sesso[0] # nome
	sesso = nome_sesso[1] # sesso
	c = cognome() # cognome
	email = get_email(n,c)
	data_nascita = data() # tupla (giorno,mese,anno)
	citta_nascita = get_citta_nascita()
	citta_nascita = sanitize_string(citta_nascita)
	citta_codice = get_citta_codice() # città residenza
	citta_residenza = sanitize_string(citta_codice[0])
	tel = get_telefono(citta_codice[2]) # telefono
	indirizzo = get_indirizzo() # indirizzo
	indirizzo = sanitize_string(indirizzo)
	cf = codice_fiscale(n,c,data_nascita,sesso,citta_codice) #codice fiscale completo
	valori["codice_fiscale"] = cf
	valori["nome"] = n
	valori["cognome"] = c
	valori["sesso"] = sesso
	valori["d_nascita"] = str(data_nascita[0])+"/"+str(data_nascita[1])+"/"+str(data_nascita[2])
	valori["c_residenza"] = citta_residenza
	valori["c_nascita"] = citta_nascita
	valori["indirizzo"] = indirizzo
	valori["telefono"] = tel
	valori["email"] = email
	return valori