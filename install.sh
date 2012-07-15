#!/bin/sh

echo "----------------------------------------"
echo "[Installing Dependencies]"
echo "----------------------------------------"
[ -f composer.phar ] || curl -s http://getcomposer.org/installer | php
php composer.phar update
php composer.phar install
echo