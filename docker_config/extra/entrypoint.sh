#!/bin/bash

chown -R $ACCESS_USER:www-data/var/www/html
chown -R $ACCESS_USER:$ACCESS_USER /home/$ACCESS_USER

supervisord -n -c /etc/supervisord.conf
