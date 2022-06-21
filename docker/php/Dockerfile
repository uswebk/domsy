FROM php:8.1.4-fpm

RUN apt update \
    && apt install -y zlib1g-dev mariadb-client vim libzip-dev \
    && docker-php-ext-install zip pdo_mysql \
    && apt install -y git \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt install -y npm \
    && npm install n -g \
    && n stable

WORKDIR /var/www