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


comuni = {}
regioni = {}

for line in file:

	args = line.split(';')

	nome = args[1].replace("'","")
	provincia = args[2]
	cap = args[5]
	regione = get_nome_regione(args[3])

	comuni[nome] = [nome,provincia,cap,regione]


output = open('dump_citta.sql','w')

output.write("SET FOREIGN_KEY_CHECKS = 0;\n")
output.write("TRUNCATE Citta;\n")

output.write("INSERT INTO Citta (Nome,Provincia,CAP,Regione) VALUES \n")

for key in comuni:
	output.write("('"+comuni[key][0]+"','"+comuni[key][1]+"',"+comuni[key][2]+",'"+comuni[key][3]+"'),\n")
output.write(";\n")

output.write("SET FOREIGN_KEY_CHECKS = 1;")
