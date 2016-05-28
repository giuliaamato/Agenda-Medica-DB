import random


DOMINI = [

	'gmail.com',
	'aruba.it',
	'libero.it',
	'yahoo.it',
	'hotmail.it',

]

def sanitize(s):
	return s.replace("'","")

def get_email(nome,cognome):
	i = random.randint(0,len(DOMINI)-1)
	dominio = DOMINI[i]
	ctrl_num = random.randint(1,100)
	nome = sanitize(nome)
	cognome = sanitize(cognome)
	nome_utente = nome.lower()+cognome.lower()+str(ctrl_num)
	return nome_utente+dominio