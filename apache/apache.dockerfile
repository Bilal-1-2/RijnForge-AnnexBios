FROM php:8.4.27-apache

# Install system dependencies and PHP extensions
RUN apt-get update && \
    apt-get install -y libmariadb-dev libzip-dev zip unzip && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite proxy proxy_http

COPY phpmyadmin-proxy.conf /etc/apache2/conf-enabled/
COPY servername.conf /etc/apache2/conf-enabled/

WORKDIR /var/www/html