#!/bin/sh

sudo DEBIAN_FRONTEND=noninteractive apt-get -y install iptables-persistent

sudo sysctl net.ipv4.ip_forward=1
sudo bash -c 'echo "1" > /proc/sys/net/ipv4/ip_forward'

sudo iptables -F
sudo iptables -F -t nat
sudo iptables -F -t mangle

sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
sudo iptables -A FORWARD -i eth0 -o eth1 -m state --state RELATED,ESTABLISHED -j ACCEPT
sudo iptables -A FORWARD -i eth1 -o eth0 -j ACCEPT

sudo bash -c 'iptables-save > /etc/iptables-up.rules'