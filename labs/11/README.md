# CSCD27 Lab 11: Web Security

## Setup

These challenges requires a web application hosted on a vagrant box:
```shell
cd ~/cscd27f16_space/CSCD27-F16/assignments/03/code/part3
$ vagrant up
```

You should **not** ssh into the vagrant. Instead, all interactions can be done through the web browser by visiting [here](http://localhost:8080/).

While using and attacking this web application, you may want to reset it. No need to reset the vagrant, you can just reset the web application by visiting [the reset page](http://localhost:8080/reset.php).

## Mapping and analyzing a web application

Using the Chrome (or Firefox) developpers console, use the app and collect all HTTP requests that performs the following actions:

| User Action                              | Path                    | HTTP method             |  Arguments             |
| -----------------------------------------|:-----------------------:|:-----------------------:|:-----------------------:
| Sign-in                                  | /login.php              | POST                    | email, password        |
| Sign-up                                  |                         |                         |                        |
| Post a message                           |                         |                         |                        |
| Delete a message                         |                         |                         |                        |
| Change the profile picture (with a URL)  |                         |                         |                        |
| Change the profile picture (with a file) |                         |                         |                        |

## Setting up attacks with Python

All attacks described below (CSRF, XSS, SQLi and File Inclusion) can be executed manually through the web application. However, it is always good to automate these attacks with a script. In the file named `example.py`, there are examples showing how to interact with a web application using python.

For example, the code below is supposed to post a message on the microblogging application by sending an HTTP GET request to the server with the message as argument:

    ```python
    import requests
    res = requests.get('http://localhost:8080/post.php', params={'msg': "hello world!"})
    print res.text
    ```

However, this does not work since Mallory needs to be authenticated first before posting messages. After Mallory enters its login and password, the server returns a cookie with the session id. By default, web browsers use this cookie to perform authenticated HTTP requests. This is not automatic in Python unless said explicitly by creating a session object:

    ```python
    import requests
    # start a session
    with requests.Session() as s:
         # sign-in as mallory (POST request)
         res = s.post(BASE + '/signin.php', data=mallory)
         # post a message (GET request)
         res = s.get(BASE + '/post.php', params={'msg': "hello world!"})
    ```

In the following, try to perform the action manually first using the browser. Once it works and you understand what is happening, write the corresponding python script that does the same thing automatically.

## Cross-Site Request Forgery (CSRF)

As Mallory, update Mallory's profile picture with the following address. Refresh the main several times. What do you observe?

```
http://localhost:8080/post.php?msg=Worm%20Attack
```

** Task **: Write a python code that performs the attack given aboce automatically.

## Cross-Site Scripting (XSS)

As Mallory, post the following message. What do you observe?

```javascript
<script>alert(document.cookie);</script>
```

** Task **: Write a python code that performs the attack given aboce automatically.

## SQL Injection

As Mallory, login with the following credentials and post a message. What do you observe?

- email: 	0' UNION SELECT ‘mallory@example.com’,'Lucky  Charm’,password FROM users where email = ‘mallory@example.com
- password: 123456

** Task **: Write a python code that performs the attack given aboce automatically.

## File Inclusion

As Mallory, create the following PHP file and upload this file as Mallory's profile picture. What do you observe?

```php
<?php
    phpinfo();
?>
```

** Task **: Write a python code that performs the attack given aboce automatically.



