FROM php:8.0-apache	
# https://github.com/docker-library/php

RUN a2enmod rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql gettext

COPY apache.conf /etc/apache2/sites-enabled/localhost.conf
COPY php.ini /usr/local/etc/php/conf.d/php.ini

EXPOSE 80