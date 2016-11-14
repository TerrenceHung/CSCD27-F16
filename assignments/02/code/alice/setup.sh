#!/usr/bin/env bash

sudo apt-get update
sudo DEBIAN_FRONTEND=noninteractive apt-get install curl nodejs npm -y
if ! [ -e /usr/bin/node ]; then
    sudo ln -s /usr/bin/nodejs /usr/bin/node
fi

# remove SSH access
# vagrant ssh -c "who -a"