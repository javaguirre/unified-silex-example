# Installing the Vagrant way

    vagrant up

You could see then the app in your host localhost:8000

# Installing locally

## Install for the example (ubuntu)

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install

### Install Silex

http://silex.sensiolabs.org/doc/intro.html

### Static files (needs node-npm)

    sudo apt-get install npm
    npm -g install bower
    bower install ; to get the static files

## Execute the example

    php -S localhost:8000 -t web web/index.php

## References

I used this repository as an example

https://github.com/helios-ag/Silex-Upload-File-Example
