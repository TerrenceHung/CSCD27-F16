#!/bin/sh

sudo DEBIAN_FRONTEND=noninteractive apt-get -y install iptables iptables-persistent

sudo sysctl -w net.ipv4.ip_forward=1

sudo iptables -F
sudo iptables -F -t nat
sudo iptables -F -t mangle

sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
sudo iptables -A FORWARD -i eth0 -o eth1 -m state --state RELATED,ESTABLISHED -j ACCEPT
sudo iptables -A FORWARD -i eth1 -o eth0 -j ACCEPT

sudo bash -c 'iptables-save > /etc/iptables/rules.v4'