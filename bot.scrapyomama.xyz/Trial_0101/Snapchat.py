#!/usr/bin/python
# -*- coding: utf-8 -*-

__author__ = "Matthew Meyer thanks to many Githubs"
__copyright__ = "Copyright (C) 2014 Matthew Meyer"
__license__ = "At least ask before using it : api.snapchat@gmail.com"
__version__ = "1.1"

import requests
import hashlib
from base64 import b64decode, b64encode
import warnings
import time
import json
import uuid
#from Crypto.Cipher import AES

warnings.filterwarnings('ignore')

SECRET =                             'iEk21fuwZApXlz93750dmW22pw389dPwOk'
STATIC_TOKEN =                       'm198sOkJEn37DjqZ32lpRu76xmw288xSQ9'
BLOB_ENCRYPTION_KEY =                'M02cnQ51Ji97vwT4'
HASH_PATTERN =                       '0001110111101110001111010101111011010001001110011000110001000110'

MEDIA_IMAGE =                        0  # Media: Image
MEDIA_VIDEO =                        1  # Media: Video
MEDIA_VIDEO_NOAUDIO =                2  # Media: Video without audio
MEDIA_FRIEND_REQUEST =               3  # Media: Friend Request
MEDIA_FRIEND_REQUEST_IMAGE =         4  # Media: Image from unconfirmed friend
MEDIA_FRIEND_REQUEST_VIDEO =         5  # Media: Video from unconfirmed friend
MEDIA_FRIEND_REQUEST_VIDEO_NOAUDIO = 6  # Media: Video without audio from unconfirmed friend

STATUS_NONE =                       -1  # Snap status: None
STATUS_SENT =                        0  # Snap status: Sent
STATUS_DELIVERED =                   1  # Snap status: Delivered
STATUS_OPENED =                      2  # Snap status: Opened
STATUS_SCREENSHOT =                  3  # Snap status: Screenshot

FRIEND_CONFIRMED =                   0  # Friend status: Confirmed
FRIEND_UNCONFIRMED =                 1  # Friend status: Unconfirmed
FRIEND_BLOCKED =                     2  # Friend status: Blocked
FRIEND_DELETED =                     3  # Friend status: Deleted

PRIVACY_EVERYONE =                   0  # Privacy setting: Accept snaps from everyone
PRIVACY_FRIENDS =                    1  # Privacy setting: Accept snaps only from friends


def pkcs5_pad(data, blocksize=16):
    pad_count = blocksize - len(data) % blocksize
    return data + (chr(pad_count) * pad_count).encode('utf-8')

def decrypt_story(data, key, iv):
    akey = b64decode(key)
    aiv = b64decode(iv)
    cipher = AES.new(akey, AES.MODE_CBC, aiv)
    return cipher.decrypt(pkcs5_pad(data))

def is_video(data):
	return True if data[0:2] == b'\x00\x00' else False

def is_image(data):
	return True if data[0:2] == b'\xFF\xD8' else False

def is_zip(data):
	return True if data[0:2] == b'PK' else False

def now():
	return "%d" % (time.time() * 1000)

"""Construct a :class:`Snapchat` object used for communicating
    with the Snapchat API.
"""

class Snapchat():
	def __init__(self, username, password, proxies = {}):
		self.proxies = proxies
		self.username = username.lower()
		self.password = password
		self.auth_token = ''
		self.uri = 'https://app.snapchat.com'
		self.urlToken = 'https://api-snapchat.herokuapp.com/api/token/trial'
		# PUBLIC KEY IS A PERSONAL KEY 
		self.publicKey = '093e84D6V9'

	def request(self, endpoint, auth_token="", post = True, params = {}, files = {}):
		tokenParams = {
				"username": self.username,
				"password": self.password,
				"endpoint": str(endpoint),
				"publicKey" : self.publicKey
				}
		if len(auth_token):
			tokenParams['token'] = auth_token
		r_tokens = requests.get(self.urlToken, params = tokenParams, verify = False)
		r_tokens = r_tokens.json()
		if r_tokens['code'] == 200:
			if endpoint == '/loq/login':
				params = r_tokens['params']
				headers = r_tokens['headers']
				r = requests.post(self.uri + endpoint, data = params, headers = headers, verify = False, proxies = self.proxies)
				return r
			else:
				params.update(r_tokens['endpoints'][0]['params'])
				headers = r_tokens['endpoints'][0]['headers']
				if post:
					r = requests.post(self.uri + endpoint, data = params, files = files, headers = headers, verify = False, proxies = self.proxies)
				else:
					r = requests.get(self.uri + endpoint, params = params, files = files, headers = headers, verify = False, proxies = self.proxies)
				return r
		else:
			return r_tokens

	def login(self):
		r = self.request("/loq/login")
		if r.status_code in [200, 201, 202]:
			try:
				r = r.json()
				print 'LOGIN : SUCCESS'
				self.auth_token = r['updates_response']['auth_token']
				print self.auth_token
				return {'response' : r, 'status' : 200}
			except:
				pass
				return r
		else:
			return r
	
	def set_auth_token(self, token):
		self.auth_token = token
		return self.auth_token

	def get_auth_token(self):
		return self.auth_token

	def updates(self):
		r = self.request("/loq/all_updates", auth_token = self.auth_token)
		if r.status_code in [200, 201, 202]:
			try:
				r = r.json()
				return {'response' : r, 'status' : 200}
			except:
				pass
				return r
		else:
			return r
		
	def make_media_id(self, username):
		return '{username}~{uuid}'.format(username = username.upper(), uuid = str(uuid.uuid1()))

	def get_media_type(self, data):
		if is_video(data):
			return MEDIA_VIDEO
		if is_image(data):
			return MEDIA_IMAGE
		if is_zip(data):
			return MEDIA_VIDEO
		return None

	def upload(self, path, media_id):
		with open(path, 'rb') as f:
			data = f.read()
		media_type = self.get_media_type(data)
		params = {
			"zipped": "0",
			"media_id": media_id,
			"username": self.username,
			"type": media_type
		}
		return self.request("/bq/upload", auth_token = self.auth_token, params = params, files = {'data': data})

	def send_to_story(self, path, time = 7, media_type = 0, thumbnail = None):
		media_id = self.make_media_id(self.username)
		self.upload(path, media_id)
		params = {
			"caption_text_display": "",
			"orientation": "0",
			"story_timestamp": now(),
			"time": time,
			"type": media_type,
			"username": self.username,
			"client_id": media_id,
			"media_id": media_id,
			"camera_front_facing": "0",
			"zipped": "0"
		}
		r = 0
		if thumbnail:
			r = self.request("/bq/post_story", auth_token = self.auth_token, params = params, files = {'thumbnail_data': open(thumbnail, 'rb')})
		else:
			r = self.request("/bq/post_story", auth_token = self.auth_token, params = params)
		if r.status_code in [200, 201, 202]:
			try:
				r = r.json()
				return {'response' : r, 'status' : 200}
			except:
				pass
				return r
		else:
			return r

	def send(self, path, recipients, time = 7):
		media_id = self.make_media_id(self.username)
		self.upload(path, media_id)
		params = {
			"recipients": json.dumps(recipients),
			"orientation": 0,
			"recipient_ids": json.dumps(recipients),
			"time": time,
			"reply": 0,
			"username": self.username,
			"features_map": "{}",
			"media_id": media_id,
			"country_code": "US",
			"camera_front_facing": 0,
			"zipped": 0
		}
		r = self.request("/loq/send", auth_token = self.auth_token, params = params)
		if r.status_code in [200, 201, 202]:
			try:
				r = r.json()
				return {'response' : r, 'status' : 200}
			except:
				pass
				return r
		else:
			return r

	def add_friend(self, friend):
		params = {
			'action': 'add',
			'friend': friend,
			'username': self.username,
			'identity_profile_page': 'ADDED_BY_USERNAME'
		}
		r = self.request("/bq/friend", auth_token = self.auth_token, params = params)
		if r.status_code in [200, 201, 202]:
			try:
				r = r.json()
				return {'response' : r, 'status' : 200}
			except:
				pass
				return r
		else:
			return r

	def delete_friend(self, friend):
		params = {
			'action': 'delete',
			'friend': friend,
			'username': self.username,
		}
		r = self.request("/bq/friend", auth_token = self.auth_token, params = params)
		if r.status_code in [200, 201, 202]:
			try:
				r = r.json()
				return {'response' : r, 'status' : 200}
			except:
				pass
				return r
		else:
			return r

	# def clear_feed(self):
	# 	params = {
	# 		'username': self.username
	# 	}
	# 	return self.request('/loq/clear_feed', auth_token=self.auth_token, params=params)

	# def get_snaptag(self):
	# 	updates = self.updates()

	# 	if updates['status'] in [200, 201, 202]:
	# 		qr_path = updates['result']['updates_response']['qr_path']
	# 		params = {
	# 			'image': qr_path,
	# 			'username': self.username,
	# 			'timestamp': now()
	# 		}

	# 		return self.request('/bq/snaptag_download', auth_token=self.auth_token, params=params)
	# 	else:
	# 		return updates

	# def user_exists(self, username):
	# 	params = {
	# 		"request_username": username,
	# 		"username": self.username
	# 	}

	# 	return self.request('/bq/user_exists', auth_token=self.auth_token, params=params)

	
	# def update_privacy(self, privacy):
	# 	params = {
	# 		'username': self.username,
	# 		'action': 'updatePrivacy',
	# 		'privacySetting': privacy
	# 	}

	# 	return self.request('/ph/settings', auth_token=self.auth_token, params=params)

	# def update_story_privacy(self, privacy):
	# 	params = {
	# 		'username': self.username,
	# 		'action': 'updateStoryPrivacy',
	# 		'privacySetting': privacy
	# 	}

	# 	return self.request('/ph/settings', auth_token=self.auth_token, params=params)

	# def get_settings(self):
	# 	params = {
	# 		'username': self.username
	# 	}

	# 	return self.request('/ph/settings', auth_token=self.auth_token, params=params, post=False)

	# def get_blob(self, snap_id):
	# 	params = {
	# 		'id': snap_id,
	# 		'username': self.username
	# 	}

	# 	return self.request('/bq/blob', auth_token=self.auth_token, params=params)['result']

	def get_story_data(self, url, story_key, story_iv):
		r = requests.get(url, verify=False)

		return decrypt_story(r.content, story_key, story_iv)

	# def set_location(self, latitude, longitude):
	# 	params = {
	# 		'lat': latitude,
	# 		'long': longitude,
	# 		'loc_accuracy_in_meters': 65.0,
	# 		'checksums_dict': '{}',
	# 		'username': self.username
	# 	}

	# 	return self.request('/loq/loc_data', auth_token=self.auth_token, params=params)

	# def get_snaps(self):
	# 	snaps = []
	# 	conversations = self.updates()['result']['conversations_response'][:-1]

	# 	for conversation in conversations:
	# 		num_pending = len(conversation['pending_received_snaps'])
	# 		for i in range(0, num_pending):
	# 			snap = (_map_keys(conversation['pending_received_snaps'][i]))
	# 			snaps.append(snap)

	# 	return snaps

	# def send_events(self, events, data=None):
	# 	if data is None:
	# 		data = {}

	# 	params = {
	# 		'events': json.dumps(events),
	# 		'json': json.dumps(data),
	# 		'username': self.username
	# 	}
	# 	return self.request('/bq/update_snaps', auth_token=self.auth_token, params=params)

	# def mark_viewed(self, snap_id, view_duration=1):
	# 	now = time.time() * 1000
	# 	data = {snap_id: {u't': now, u'sv': view_duration}}
	# 	events = [
	# 		{
	# 			u'eventName': u'SNAP_VIEW', u'params': {u'id': snap_id},
	# 			u'ts': int(round(now)) - view_duration
	# 		},
	# 		{
	# 			u'eventName': u'SNAP_EXPIRED', u'params': {u'id': snap_id},
	# 			u'ts': int(round(now))
	# 		}
	# 	]
	# 	return self.send_events(events, data)
