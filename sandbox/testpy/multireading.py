import random
import sys
from threading import Thread
import time
import requests
import mongoengine
import sys
from mongoengine import *

class Afficheur(Thread):
	
	
	def __init__(self, lettre):
	    Thread.__init__(self)
	    self.lettre = lettre
	
	def run(self):

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
		
		

thread_1 = Afficheur("1")
thread_2 = Afficheur("2")

thread_1.start()
thread_2.start()

thread_1.join()
thread_2.join()