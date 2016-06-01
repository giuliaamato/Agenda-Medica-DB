import sys
import random

COD_ESENZIONE = ['A','B','C']


def getData():
	in_file = open(sys.argv[1],'r')
	rows = []
	for i in in_file:
		rows.append(i)
	for j in range(1,4):
		rows.pop(0)
	rows.pop()
	for n in range(0,len(rows)):
		rows[n] = rows[n].replace("(","")
		rows[n] = rows[n].replace("'","")
		rows[n] = rows[n].replace(")","")
		rows[n] = rows[n].replace("\n","")
		rows[n] = rows[n].replace(";","")
		rows[n] = rows[n].split(",")
		rows[n].pop()
	return rows

def makeSQLLines(filename,user):

	if user == 'Admin':
		cols = "(CodiceFiscale,NomeUtente,Stipendio)"
	elif user == 'Paziente':
		cols = "(CodiceFiscale,CodiceEsenzione)"
	elif user == 'Infermiere':
		cols = "(CodiceFiscale,Stipendio,Tirocinante)"


	filename.write("SET FOREIGN_KEY_CHECKS=0;\n")
	filename.write("TRUNCATE "+user+";\n")
	filename.write("INSERT INTO "+user+" "+cols+" VALUES\n")


def dumpAdmin():
	rows = getData()
	out_f = open('dump_admin.sql','w')
	makeSQLLines(out_f,'Admin')
	for entry in rows:
		stip = str(random.randint(35000,45000))
		year = entry[1].split('-')[2][-2:]
		username = entry[2].lower()+entry[3].lower()+year
		cf = entry[0]
		out_f.write("('"+cf+"','"+username+"',"+stip+"),\n")
	out_f.write(";")
	out_f.write("SET FOREIGN_KEY_CHECKS = 1;")


def dumpPaziente():
	rows = getData()
	out_f = open('dump_pazienti.sql','w')
	makeSQLLines(out_f,'Paziente')
	for entry in rows:
		cf = entry[0]
		cod_es = str(random.randint(1,99))
		if int(cod_es) < 10:
			cod_es = "0"+cod_es
		cod_es = COD_ESENZIONE[random.randint(0,len(COD_ESENZIONE)-1)]+cod_es
		out_f.write("('"+cf+"','"+cod_es+"'),\n")
	out_f.write(";")
	out_f.write("SET FOREIGN_KEY_CHECKS = 1;")


def dumpInfermieri():
	rows = getData()
	out_f = open('dump_infermieri.sql','w')
	makeSQLLines(out_f,'Infermiere')
	for entry in rows:
		cf = entry[0]
		stip = str(random.randint(12000,17000))
		t = str(random.randint(0,1))
		out_f.write("('"+cf+"',"+stip+","+t+"),\n")
	out_f.write(";")
	out_f.write("SET FOREIGN_KEY_CHECKS = 1;")


def manageFile():
	print "Selezionare utente di cui fare il dump:"
	print "a(admin) p(paziente) i(infermiere)"
	inp = raw_input()

	if inp == 'a':
		dumpAdmin()
	elif inp == 'i':
		dumpInfermieri()
	elif inp == 'p':
		dumpPaziente()
	






def makeDump():

	if len(sys.argv) > 1:
		manageFile()
	else:
		print "Fornire nome del file"









if __name__ == '__main__':
	makeDump()