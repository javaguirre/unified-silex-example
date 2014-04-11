#!/bin/bash
# TODO We could check if repositories already in apt
# and if the unified repository is already there
# but this is working for the demo

# PHP5 and git
sudo apt-get -y update
sudo apt-get -y install git python-software-properties curl

# Newer php and node
sudo add-apt-repository ppa:chris-lea/node.js
sudo add-apt-repository ppa:ondrej/php5

sudo apt-get -y update
sudo apt-get -y install php5-cli nodejs

# Install mp4split
sudo sh -c 'echo "deb http://repository.unified-streaming.com/ precise multiverse" >> /etc/apt/sources.list'
wget http://repository.unified-streaming.com/unifiedstreaming.pub
sudo apt-key add unifiedstreaming.pub
sudo apt-get -y update
sudo apt-get -y install libexpat1 libpcrecpp0 uuid libsqlite3-0 libcurl3
sudo apt-get -y install mp4split

# Unified example
git clone https://github.com/javaguirre/unified-silex-example.git unified
cd unified

# Bower
sudo npm -g install bower
bower install

# Silex
curl -sS https://getcomposer.org/installer | php
php composer.phar install

# Run the app
nohup php -S localhost:8000 -t web web/index.php &
