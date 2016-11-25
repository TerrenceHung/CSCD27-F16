#!/usr/bin/env bash

sudo apt-get update
debconf-set-selections <<< 'mysql-server mysql-server/root_password password pass4root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password pass4root'
sudo apt-get install curl apache2 mysql-server php5-mysql php5 libapache2-mod-php5 php5-mcrypt -y

# ####### enable challenge 18 ########
sudo sed  '/\[mysqld\]/a secure-file-priv = \"\"' /etc/mysql/my.cnf
sudo usermod -a -G www-data  mysql
sudo chmod g+w /var/www/html/media/uploads/
sudo service mysql restart
######################################

sudo rm -Rf file /var/www/html/*
sudo cp -R /vagrant/microblogging/* /var/www/html/.
sudo chown -R www-data:www-data /var/www/
sudo service apache2 restart

curl http://localhost/reset.php
