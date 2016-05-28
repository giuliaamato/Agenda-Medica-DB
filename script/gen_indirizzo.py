from lxml import html
import requests
import random

pagina = requests.get('https://it.wikipedia.org/wiki/Stradario_di_Treviso')
tree = html.fromstring(pagina.content)
nomi = tree.xpath('//div[@id="mw-content-text"]/dl/dt/text()')


def sanitize():
	for i in nomi:
		if len(i) <= 4:
			nomi.remove(i)
		else:
			try:
				i = i.decode('latin_1')
			except:
				nomi.remove(i)

		

def get_indirizzo():
	i = random.randint(0,len(nomi))
	return nomi[i]