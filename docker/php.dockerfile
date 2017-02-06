FROM php:7.1-fpm-alpine

## Installs extensions
RUN apk add --no-cache \
        postgresql-dev \
        gettext-dev \
        libmcrypt-dev \
        ## XDebug build dependencies
        autoconf g++ make \

    && rm -rf /var/cache/apk/* \
    && find / -type f -iname \*.apk-new -delete \
    && rm -rf /var/cache/apk/* \

    && docker-php-ext-install gettext mcrypt pdo pdo_pgsql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && sed -i '1 a xdebug.remote_enable=On' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && sed -i '1 a xdebug.remote_autostart=true' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && sed -i '1 a xdebug.remote_mode=req' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && sed -i '1 a xdebug.remote_handler=dbgp' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && sed -i '1 a xdebug.remote_connect_back=On' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && sed -i '1 a xdebug.remote_host=172.17.0.1' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && sed -i '1 a xdebug.remote_port=9001' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

## Installs Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --filename=composer.phar \
    --install-dir=/usr/local/bin
COPY composer /usr/local/bin
