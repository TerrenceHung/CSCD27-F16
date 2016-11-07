import requests
import threading

SERVER = "mathlab.utsc.utoronto.ca";
PATH = "/courses/cscd27f16/assignment/02/server/"
DATA = {"username": "alice","password": "pass4alice"}

def do_request():
  threading.Timer(5.0, do_request).start()
  r1 = requests.get("http://" + SERVER + PATH)
  protocol = r1.url.rsplit('://', 1)[0]
  r2 = requests.post(protocol + "://" +  SERVER + PATH + "login.php", data=DATA)
  print(r2.text)

do_request()





