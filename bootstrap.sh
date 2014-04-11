#!/bin/bash
# TODO We could check if repositories already in apt
# and if the unified repository is already there
# but this is working for the demo

# PHP5 and git
sudo apt-get -y update
sudo apt-get -y install git python-software-properties
sudo add-apt-repository ppa:ondrej/php5
sudo apt-get -y update
sudo apt-get -y install php5-cli

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
php -S localhost:8000 -t web web/index.php
