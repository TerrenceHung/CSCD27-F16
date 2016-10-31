# CSCD27 Lab 7: Packet Sniffing

## Vagrant Setup

Make sure to setup your environment as described in the [Vagrant Setup Guideline](https://github.com/ThierrySans/CSCD27-F16/blob/master/assignments/02/VAGRANT.md).

## Packet Sniffing with Wireshark

In this part, Mallory will start Wireshark and capture the traffic on `eth1`:

```shell
vagrant@mallory:~$ sudo wireshark &> /dev/null &
```

Ignore the error message at the beginning and, in the "capture" column, select `eth1` and click the green `start` button.

## Generating HTTP traffic

In this part, Alice will fetch a webpage on the Mathlab server (HTTP request) and the server will return the HTML document (HTTP response):

*As Alice*, get the webpage (using curl):

```shell
vagrant@alice:~$ curl http://mathlab.utsc.utoronto.ca/
```

The server should respond with the corresponding HTML document:

```shell
<html><body><h1>It works!</h1>
<p>This is the default web page for this server.</p>
<p>The web server software is running but no content has been added, yet.</p>
</body></html>
````

## Following a TCP Stream

In this part, Mallory will capture the communication between Alice and the Mathlab server. At the application layer, there are two messages exchanges: 1) HTTP request (from the client to the server) and 2) the HTTP response (from the server to the client). However, at the TCP layer, these two messages generates several TCP messages that we call the "TCP stream". The TCP stream can be divided into three parts:

1. TCP 3-way handshake to initiate the communication

| ## | from   |  to    | protocol |  Info                 |
| -- | ------ | ------ | -------- | --------------------- |
|  1 | client | server | TCP      | TCP SYN               |
|  2 | server | client | TCP      | TCP SYN-ACK           |
|  3 | client | server | TCP      | TCP ACK               |

2. Data exchange

| ## | from   |  to    | protocol |  Info                 |
| -- | ------ | ------ | -------- | --------------------- |
|  4 | client | server | HTTP     | HTTP request          |
|  5 | server | client | TCP      | TCP ACK               |
|  6 | server | client | HTTP     | HTTP response         |
|  7 | client | server | TCP      | TCP ACK               |


3. TCP 4-way handshake to terminiate the communication

| ## | from   |  to    | protocol |  Info                 |
| -- | ------ | ------ | -------- | --------------------- |
|  8 | client | server | TCP      | TCP FIN-ACK           |
|  9 | server | client | TCP      | TCP ACK               |
| 10 | server | client | TCP      | TCP FIN-ACK           |
| 11 | client | server | TCP      | TCP ACK               |

*As Mallory*, isolate a TCP stream in Wireshark:

1. find the http request in wireshark
2. click right and select "Follow TCP Stream" (for now, we will ignore and close the modal window)

## Saving a TCP stream

In assignment 2, you will be asked to capture a TCP stream, save it to a text file and submit it to show that the work has been completed.

*As Mallory*, capture TCP stream with Wireshark:

1. select one of the packets in the TCP stream
2. click right and select "Follow TCP Stream" (do not close the modal window this time)
3. click on "Save As" and save the file under the path `/vagrant/mallory/results/` to make it accessible from the host
4. as a verification step, open this file on the host using any text editor and check that the right TCP stream was captured. The file can be found at: `~/cscd27f16_space/CSCD27-F16/assignments/02/code/mallory/results/`

From this TCP stream, can Mallory see:

- which page Alice has been requested (HTTP request)?
- the HTML document returned by the server (HTTP response)?

## Generating HTTPs traffic

*As Alice*, initiate an HTTPS communication:

```shell
vagrant@alice:~$ curl https://mathlab.utsc.utoronto.ca/
```

While eavesdropping on this TCP stream, can Mallory see:

- which web page Alice has been requested?
- the HTML document returned by the server?


