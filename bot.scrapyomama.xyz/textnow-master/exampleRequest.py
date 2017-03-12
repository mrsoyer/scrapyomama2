import signature
import random
import json
import requests

class main(object):
    def __init__(self):
        self.session = requests.session()
        self.username = "bsbsjdjjdjdjhb"
        self.email = "bvcsjsjj@yopmail.com"
        self.sig = signature.generate()
        self.signature = self.sig.signature(method="PUT",
                                            url="https://api.textnow.me/api2.0/users/%s?client_type=TN_WIN_PHONE"%self.username,
                                            json=json.dumps({
                                                    "password": "apple123",
                                                    "email": self.email,
                                                    "first_name": "gg",
                                                    "last_name": "fcv",
                                                }))
        self.register()

    def register(self):
        self.request = self.session.put('https://api.textnow.me/api2.0/users/bsbsjdjjdjdjhb?client_type=TN_WIN_PHONE&signature=%s'%self.signature,
                         data={'json': json.dumps({
                                                    "password": "apple123",
                                                    "email": self.email,
                                                    "first_name": "gg",
                                                    "last_name": "fcv",
                                                })},
                         proxies={
                            'https': 'http://127.0.0.1:8888',
                            'http': 'http://127.0.0.1:8888',
                         },
                         verify=False,
                         headers={
                            'User-Agent': 'TextNow 1.1.0.2 (NOKIA RM-915_nam_canada_222; WP 8.0.10328.0; English (Canada))',
                            'If-Modified-Since': '2014-07-25 05:00:15',
                         })
        print(self.request.content)
        print(self.request.url)

if __name__ == "__main__":
    main()