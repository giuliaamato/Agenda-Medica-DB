from citta_comuni import get_provincia
import random

ASL = {
	
	"VI":1,
	"PD":2,
	"VE":3,
	"VR":4,
	"BL":5,
	"TV":6,
	"RO":7,
	"CH":8,
}



def find_asl(citta_residenza):
	provincia = get_provincia(citta_residenza)
	try:
		cod = ASL[provincia]
	except:
		k = random.choice(ASL.keys())
		cod = ASL[k]
	return cod



