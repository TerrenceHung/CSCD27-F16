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

# reset the web application
requests.get(BASE + '/reset.php')

# start a session
with requests.Session() as s:
     # sign-in as mallory (POST request)
     res = s.post(BASE + '/signin.php', data=mallory)

     # post a message (GET request)
     res = s.get(BASE + '/post.php', params={'msg': "hello world!"})

     # content spoofing
     params = urllib.urlencode({'msg':"""
         <h1>I can inject HTML tags!</script>
     """})
     res = s.get(BASE + '/post.php', params=params)

     # change profile picture (using a url)
     data = {'optionsimagetype' : 'url', 'url' : 'https://thisdata.com/blog/content/images/2016/08/ComputerworldCreditThinkstock.jpg'}
     s.post(BASE + '/profile.php', data=data)

     # change profile picture (using a file)
     data = {'optionsimagetype' : 'file'}
     files = {'upfile': open(os.path.dirname(os.path.abspath(__file__)) + '/../microblogging/provision/black-hat.png', 'rb')}
     s.post(BASE + '/profile.php', data=data, files=files)