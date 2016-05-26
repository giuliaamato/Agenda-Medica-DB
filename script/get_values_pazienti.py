from lxml import html
import requests
import random
from nomi import MASCHI, FEMMINE
from get_codice_catastale import get_citta_codice
from control_char import controllo

COGNOMI_PAGE = requests.get('http://www.cognomix.it/top100_cognomi_italia.php')
COGNOMI_TREE = html.fromstring(COGNOMI_PAGE.content)
COGNOMI = COGNOMI_TREE.xpath('//td[@class="text-center"]/strong/text()')



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
		r = random.randint(1,len(MASCHI))
		return (MASCHI[r],SESSO[0])
	else:
		r = random.randint(1,len(FEMMINE))
		return (FEMMINE[r],SESSO[1])

def cognome():
	c = COGNOMI.pop()
	c = c.lower().capitalize()
	return c


def del_vowels(s):
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
	nascita_anno = str(data[2])[-2:]
	nascita_mese = get_mese(data[1])
	nascita_giorno = get_giorno(data[0],sesso)
	codice_catastale = citta_codice[1]
	cf = cognome+nome+nascita_anno+nascita_mese+nascita_giorno+codice_catastale
	cf += controllo(cf)
	return cf

def crea_valori():
	nome_sesso = nome()
	n = nome_sesso[0] # nome
	sesso = nome_sesso[1]
	c = cognome() # cognome
	data_nascita = data()
	citta_codice = get_citta_codice()
	cf = codice_fiscale(n,c,data_nascita,sesso,citta_codice)

	print n
	print c
	print sesso
	print data_nascita
	print cf.upper()





if __name__ == '__main__':
	crea_valori()