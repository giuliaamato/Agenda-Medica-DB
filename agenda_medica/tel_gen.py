import random

PROV = {
	
	'BL': '0437',
	'PD': '049',
	'VI': '0444',
	'VR': '045',
	'VE': '041',
	'RO': '0425',
	'TV': '0422',

}


def get_telefono(provincia):
	prefix = PROV[provincia]
	offset = random.randint(100000,999999)
	return prefix+str(offset)