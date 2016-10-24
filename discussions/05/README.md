# CSCD27 Discussion 5

## Network Insecurity

Alice wants to access the web server Bob.com via HTTP. However, Mallory wants to either eavesdrop or hijack (MitM) the messages sent back and forth between the two.

We consider different scenarios in which Mallory controls a host located in different part of the network. These different hosts can be typed as either:

1. a **LAN** host that is on the same broadcast network (Ethernet or WiFi) as Alice
2. a **route** host (either a gateway or a router) that is on the routing path between Alice and Bob
3. a **remote** host that is somewhere on the Internet but not necessarily on a network between Alice and Bob

5.1 For each host type, explain in technical details how Mallory can either eavesdrop or hijack (MitM) the communication between Alice and Bob.com.

| Host Setting           | Eavesdropping            | Hijaking               |
| -----------------------|:-----------------------:|:-----------------------:|
| LAN                    |                         |                         |
| Route                  |                         |                         |
| Remote                 |                         |                         |


 In your analyze, you can consider the following attacks (non-exhaustive):

- Packet sniffing
- ARP-cache poisoning
- Route Hijacking (BGP)
- DNS Spoofing

## HTTPs as a counter-measure

Let us now consider that Alice access `Bob.com` via HTTPs.

5.2 Would HTTPs defeat none, some or all attacks identified in 5.1? If so, how could Mallory defeat HTTPs (assuming that generating a valid certificate for Bob.com is not an option)?