#!/bin/sh

sudo DEBIAN_FRONTEND=noninteractive apt-get -y install iptables-persistent

sudo sysctl net.ipv4.ip_forward=1
sudo bash -c 'echo "1" > /proc/sys/net/ipv4/ip_forward'

sudo iptables -F
sudo iptables -F -t nat
sudo iptables -F -t mangle

sudo iptables -t nat -A POSTROUTING -o enp0s3 -j MASQUERADE
sudo iptables -A FORWARD -i enp0s3 -o enp0s8 -m state --state RELATED,ESTABLISHED -j ACCEPT
sudo iptables -A FORWARD -i enp0s8 -o enp0s3 -j ACCEPT

sudo bash -c 'iptables-save > /etc/iptables-up.rules'