
# CSCD27 Assignment 2

The primary goals of this assignment are to improve your understanding of how an attacker on a local network could:

- Part 1. Eavesdrop communications (Lab 7)
- Part 2. Hijack communications (Lab 8)

Good Luck!

## Instructions

### Submission

Submit on the `mathlab.utsc.utoronto.ca` system your solutions:

- for Part 1: `raw_http.txt` and `raw_https.txt`
- for Part 2: `dos.txt`, `spoof.txt` and `mitm.txt`

```shell
submit -c cscd27f16 -a a2 raw_http.txt raw_https.txt dos.txt spoof.txt mitm.txt
```

- for Part 3: `secure.txt` (optional)

```shell
submit -c cscd27f16 -a a2 raw_http.txt raw_https.txt dos.txt spoof.txt mitm.txt secure.txt
```

### Academic Integrity

___

## Overview and guidelines

In this assignment, we will use our [virtual penetration testing environment](https://github.com/ThierrySans/CSCD27-F16/blob/master/assignments/02/VAGRANT.md)) to demonstrate various attacks on a local network. As Mallory, you will first eavesdrop (Part 1) and eventually hijack (Part 2) the communication between Alice (on the local network) and Bob (mathlab.utsc.utoronto.ca). Alice and Bob exchange login, passwords and sensitive information over HTTP and HTTPS.

As Mallory, you will run your attacks as if you were in a real environment. This means that:

- you do not have access to Alice VM and its files (beyond the initial setup described below)
- you do not have access to the Gateway VM and its files
- you cannot modify the setup of the network

To initiate communication between Alice and Bob, *as Alice*, run the following program:

```shell
vagrant@alice:~$ nodejs /vagrant/alice/client.js
Welcome alice your bank account balance is $31415
Welcome alice your bank account balance is $31415
...
```

This program does not terminate. As described previously, you are not allowed to read nor modify this program. From now on, you will exclusively act *as Mallory*.

## Part 1. Eavesdropping the communication

For this part, make sure that you are able to complete [Lab 7](https://github.com/ThierrySans/CSCD27-F16/tree/master/labs/07).

**Task 1.1 (20 points):** As Mallory, eavesdrop all HTTP traffic sent between Alice and Bob. Isolate the TCP stream that contains an HTTP redirect (HTTP status code 301). Export it as `raw_http.txt` and submit it as your answer.

**Task 1.2 (20 points):** As Mallory, eavesdrop the HTTPS traffic sent between Alice and Bob. Isolate one TCP stream that contains encrypted data. Export it as `raw_https.txt` and submit it as your answer.

___

## Part 2. Hijacking the communication

For this part, make sure that you are able to complete [Lab 8](https://github.com/ThierrySans/CSCD27-F16/tree/master/labs/08).

**Task 2.1 (20 points):** As Mallory, perform a denial of service attack that will disrupt the communication between Alice and Bob.

1. On your ubuntu machine, create a new text file and save it as `dos.txt`
2. In wireshark, select one of the spoofed ARP message, copy the content (click right -> copy -> Summary (Text)) and paste it the file
3. Do the same thing as (2) for a failed TCP message

**Task 2.2 (20 points):** As Mallory, spoof the HTTP communication to return fake information to Alice. Isolate the TCP stream that shows the fake HTTP response. Export it as `spoof.txt` and submit it as your answer.

**Task 2.3 (20 points):** As Mallory, execute a man-in-the-middle attack on the HTTPS communication to obtain both Alice's requests and the server's response in plaintext. Isolate the two TCP streams that shows the man-in-the-middle attack. Export it as `mitm.txt` and submit it as your answer.

## Part 3. Securing the communication

**Task 3 (10 bonus points):** Websites like Google and Facebook are not vulnerable to the SSLStripping attack. Investigate why, answer the questions in `part3.md` and submit it as your answer.


