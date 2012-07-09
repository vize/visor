#!/bin/sh

#sudo apt-get update

echo "----------------------------------------"
echo "[Installing PHP XMLRPC library]"
echo "----------------------------------------"
sudo apt-get install -y php5-xmlrpc

echo "----------------------------------------"
echo "[Installing Supervisor]"
echo "----------------------------------------"
sudo apt-get install -y python-setuptools
sudo easy_install supervisor

echo "----------------------------------------"
echo "[Installation Complete]"
echo "----------------------------------------"
echo "Version:" $(supervisord -v)

echo "----------------------------------------"
echo "[Installing Dependencies]"
echo "----------------------------------------"
curl -s http://getcomposer.org/installer | php
php composer.phar install
echo