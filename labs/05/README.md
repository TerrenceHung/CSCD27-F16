# CSCD27 Lab 5: SSL-Stripping

Looking ahead to assignment 2, we'll take a quick look at a widespread HTTPS vulnerability, that is gradually getting closed/fixed by browsers and Web sites/servers.

SSL-Stripping has-been/will-be described in more detail in class; here we're going to focus on the mechanics. If you want to skip this task, in preference to working on Asst 1, you may choose to do that.

Assignment 2 will ask you to mount an SSL-stripping attack on your browser to recover data that should be confidential, such as authentication credentials. To mount your attack, pick up a copy of the `sslstrip.tgz` tarball. Untar the file and change into the extracted directory:

```shell
tar xvzf sslstrip-0.9.tgz
cd sslstrip-0.9
```

Launch the `sslstrip` program:

```shell
python sslstrip.py -a -w log.txt -l 8080 -f
```

The sslstrip tool is designed to intercept traffic from a target (victim) host by redirecting its traffic to the attacker's computer. However, for the assignment you're <ins>not</ins> going to attempt to reroute traffic from mathlab router. Instead, we'll set up a browser-proxy as our test vehicle, which will enable you to experience the effects of an sslstrip attack without interfering with public-system resources.

A browser proxy is an agent used to process all browser requests. It is typically used to provide more efficient caching across the browsers within an organization, and to filter requests to block access to certain kinds of content.

Configure your Chrome browser to use an HTTP Proxy by starting it from the command line as shown below (**important** to avoid port conflicts, run the following command from your local Linux machine, <ins>not</ins> from the mathlab server):

```shell
chromium-browser --proxy-server="localhost:8080"
```

Once your proxy-setup step is completed your Chrome browser will forward all requests to the Proxy port you have designated, which corresponds to the port where the sslstrip agent is listening.

Navigate to a Web page that requires authentication, such as Hotmail, or the UTSC Intranet (type hotmail.com or intranet.utsc.utoronto.ca in the browser location window). Attempt to log in with bogus credentials, such as email: "superman/superwoman@gmail.com", password "supersecret".

Terminate your sslstrip program with cntl-C.

View the contents of your sslstrip log.txt file, and you should be able to find "superman@gmail.com" and "supersecret" in the file.

You may prefer to use a different browser such as Firefox, which displays a more convincing padlock favicon. In that case, within Firefox go to `Preferences/Advanced/Network/Connection/Settings` Select `Manual proxy configuration`, and enter `localhost` as the HTTP Proxy with a port number that matches the one used to start sslstrip (default is 8080).