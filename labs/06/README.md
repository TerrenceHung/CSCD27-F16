# CSCD27 Lab 6: Host Discovery and Port Scanning

## Know your host

On Linux, the command `ifconfig` gives you information about the interfaces that your computer have, their MAC adresses (physical adresses) and their IP addresses (W.X.Y.Z format). The lab computer have multiple interfaces but only one is connected to the internet. To know which one, you can compare this information with the IP address that google shows you when you ask `what is my ip`.

- What is the interface, MAC address and IP address connected to the internet?

## Host discovery

Using NMAP, scan the network for hosts with IP adresses that range between W.X.Y.0 and W.X.Y.255.

- How many hosts are there?

## Port scanning

Using NMAP, scan the ports of `mathlab.utsc.utoronto.ca`.

- What are the opened port?
- Using Google, can you infer the services (programs) that are running behind these ports?

## Getting information about services

Using NMAP, find the names and the versions of the software running behind these services.

- Which services leak their software name and versions?

## Getting the vulnerabilities

The CVE (Common Vulnerabilities and Exposures) is a database that records all known vulnerabilities on public software. This database is [accessible online](https://www.cvedetails.com/).

- Using this database, find if one of the service running on Mathlab has a critical vulnerability, reads its description and try to understand what it is about.

