#!/usr/bin/env bash

sudo apt-get update

sudo DEBIAN_FRONTEND=noninteractive  apt-get install python python-twisted-web dsniff wireshark -y
if ! [ -d /home/vagrant/sslstrip-0.9 ]; then
    wget https://moxie.org/software/sslstrip/sslstrip-0.9.tar.gz
    tar xvzf sslstrip-0.9.tar.gz
    rm -Rf sslstrip-0.9.tar.gz
fi