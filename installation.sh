#!/bin/bash

echo -e "\n\nUpdating Apt Packages and upgrading latest patches\n"
sudo apt-get update -y 
sudo apt-get upgrade -y

echo -e "\n\nInstalling Apache2 Web Server\n"
sudo apt-get install apache2 apache2-doc apache2-utils libexpat1 ssl-cert -y

echo -e "\n\nInstalling PHP & Requirements\n"
sudo apt-get install php libapache2-mod-php php-mysql -y

echo -e "\n\nInstall PHP extensions\n"
sudo apt-get install php-cli php-mbstring php-curl -y

echo -e "\n\nInstalling MySQL\n"
sudo apt-get install mysql-server mysql-client -y
sudo mysql_secure_installation

echo -e "\n\nEnabling Modules\n"
sudo a2enmod rewrite
sudo a2enmod ssl

echo -e "\n\nInstalling Git\n"
sudo apt-get install git

sudo rm -r /var/www/html
sudo git clone https://github.com/ryanji99/php-employee-login.git /var/www/html
mysql -u root -e "create database users";
mysql -u root -p users < /var/www/html/mysql/ours.sql

cp /var/www/html/config.example.php /var/www/html/config.php

apt install composer -y
composer install --working-dir=/var/www/html/
composer update --working-dir=/var/www/html/

echo -e "\nRestarting Apache\n"
sudo service apache2 restart

echo -e "\n\nLAMP Installation Completed"

echo -e "Installing security tools"
sudo apt-get install snort -y
sudo apt-get install ufw -y
sudo apt-get install fail2ban -y

echo -e "Edit /var/www/html/config.php!"

exit 0
