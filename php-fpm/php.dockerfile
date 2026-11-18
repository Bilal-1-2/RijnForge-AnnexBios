FROM php:8.4.27-fpm

RUN apt-get update && \
    apt-get install -y libmariadb-dev libzip-dev zip unzip && \
    docker-php-ext-install mysqli pdo pdo_mysql

# Disable OpCache for development
RUN echo "opcache.enable=0" >> /usr/local/etc/php/conf.d/opcache-dev.ini


WORKDIR /var/www/html