sudo apt-get update
sudo DEBIAN_FRONTEND=noninteractive apt-get install gdb gcc-multilib libssl-dev -y
cp /vagrant/attack2/vuln /home/vagrant/.
sudo chown root:root /home/vagrant/vuln
sudo chmod a+x /home/vagrant/vuln
sudo chmod u+s /home/vagrant/vuln
sudo bash -c 'echo "shout PWNed!" > /root/flag.txt'