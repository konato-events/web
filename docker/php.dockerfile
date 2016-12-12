FROM php:7.1-fpm-alpine

## Installs extensions
RUN apk add --no-cache \
        postgresql-dev \
        gettext-dev \
        libmcrypt-dev \
    && docker-php-ext-install gettext mcrypt pdo pdo_pgsql

## Installs Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --filename=composer \
    --install-dir=/usr/local/bin
