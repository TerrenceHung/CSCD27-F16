import os, random, string
import requests

PROTOCOL = "http"
HOST = "localhost"
PORT = "80"
BASE = PROTOCOL + "://" + HOST + ":" + PORT

requests.get(BASE + '/install.php')

users = {
    'alice':{
        'login': {
            'name': 'Alice',
            'email': 'alice@example.com',
            'password': 'pass4alice!'
        },
        'profile':{
            'optionsimagetype' : 'url',
            'url' : 'http://wondersofdisney.disneyfansites.com/disfriends/alice/alice/aliceteacup.png'
        },
        'msgs' : ["Hello everybody! I am Alice :)", "Mallory should not be trusted!"]
    },
    'mallory':{
        'login': {
            'name': 'Mallory',
            'email': 'mallory@example.com',
            'password': 'pass4mallory'
        },
        'profile':{
            'optionsimagetype' : 'file',
            'file' : {'upfile': open(os.path.dirname(os.path.abspath(__file__)) + '/black-hat.png', 'rb')}
        },
        'msgs' : ["Hey folks, I am here to hack you!"]
    }
}

for user in users:
    res = requests.post(BASE + '/signup.php', data=users[user]['login'])

    with requests.Session() as s:
        res = s.post(BASE + '/signin.php', data=users[user]['login'])

        if (users[user]['profile']['optionsimagetype'] == 'url'):
            s.post(BASE + '/profile.php', data=users[user]['profile'])
        else:
            s.post(BASE + '/profile.php', data=users[user]['profile'], files=users[user]['profile']['file'])
        for msg in users[user]['msgs']:
            res = s.get(BASE + '/post.php/?msg=' + msg)
