import sys
from get_values_pazienti import codice_fiscale


def get_codice(c_nascita):
	file = open('listacomuni.txt','r')
	
	#print c_nascita
	for line in file:
		
		args = line.split(';')
		nome_citta = args[1]
		#print nome_citta
		if nome_citta == c_nascita:
			#print args
			return args[6]

def make_codice_fiscale():
	if len(sys.argv) > 4:
		nome = sys.argv[1]
		cognome = sys.argv[2]
		data = sys.argv[3].split('-')
		data = (data[2],data[1],data[0])
		sesso = sys.argv[4].capitalize()
		c_nascita = sys.argv[5]
		
		if len(sys.argv)>6:
			c_nascita += " "+sys.argv[6]
		if len(sys.argv)>7:
			c_nascita += " "+sys.argv[7]
		codice = get_codice(c_nascita)
		#print c_nascita
		print codice_fiscale(nome,cognome,data,sesso,(c_nascita,codice))
		
if __name__ == '__main__':
	make_codice_fiscale()