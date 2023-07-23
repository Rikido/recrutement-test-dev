#!/bin/bash

sleep 30

systemctl start php-fpm
systemctl start mariadb
systemctl start httpd
