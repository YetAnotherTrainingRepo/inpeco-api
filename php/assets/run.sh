#!/bin/bash


APP_FOLDER=/var/www/html

#if the composer has been run.
if [ -f $APP_FOLDER/vendor/autoload.php ]; then
    cd $APP_FOLDER
    composer install 
fi

while true; do  
    sleep 1  
done