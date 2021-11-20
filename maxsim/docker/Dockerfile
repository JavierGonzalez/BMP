FROM php:8.0-apache	
# https://github.com/docker-library/php

RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/C=AT/ST=Vienna/L=Vienna/O=Security/OU=Development/CN=example.com"
RUN a2enmod ssl rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql gettext

COPY apache.conf /etc/apache2/sites-enabled/localhost.conf
COPY php.ini /usr/local/etc/php/conf.d/php.ini