import os, requests, urllib

PROTOCOL = "http"
HOST = "localhost"
PORT = "8080"
BASE = PROTOCOL + "://" + HOST + ":" + PORT

# Mallory's credentials
mallory = {
    'email': 'mallory@example.com',
    'password': 'pass4mallory'
}

# reset the application
requests.get(BASE + '/reset.php')

# #######  your attack goes here  #######



# #########################################
