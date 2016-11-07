#!/usr/bin/env bash

sudo apt-get update
sudo DEBIAN_FRONTEND=noninteractive apt-get install curl -y

# remove SSH access
# vagrant ssh -c "who -a"