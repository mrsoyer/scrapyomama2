import requests
import mongoengine
import sys

from mongoengine import *

"""
print connect(
    db='thomas_dev',
    username='thomas',
    password='dJPx6f63Fv',
    host='mongodb://server1.production.barney.im'
)

class User(Document):
    email = StringField(required=True)
    first_name = StringField(max_length=50)
    last_name = StringField(max_length=50)
    
ross = User(email='ross@example.com', first_name='Ross', last_name='Lawley').save()    

sys.exit()
"""

class theclass:

	def routine(self):
		
		userinsta = ["thomas garcia", "yesmen poupou", "robertine rout", "jack russel", "hibou hibou"]
		
		proxies = {
		  'http': 'http://37.48.118.90:13082',
		  'https': 'http://37.48.118.90:13082',
		}
		
		print userinsta
		i = 0
		result = []
		
		getgender = "https://api.genderize.io/?"
		
		for a in userinsta:
			asplit = a.split(' ')
			if i != 0:
				etcom = "&"
			else:
				etcom = ""
			getgender = getgender + etcom + "name[" + str(i) + "]=" + asplit[0]
			"""result.append({'name' : asplit[0]})"""
			i +=1
		
		print getgender
		r = requests.get(getgender, proxies=proxies)
		
		listname = r.json()
		
		print listname[0]["gender"]
	


#class bateau nom et couleur 	
A = theclass()

A.routine()

