FROM php:7.2-fpm

MAINTAINER "Romain Eggermont"

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql

WORKDIR /usr/share/nginx/html