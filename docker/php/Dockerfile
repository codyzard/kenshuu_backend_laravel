FROM php:7.4-fpm

WORKDIR /var/www

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && apt-get install vim -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer -y
