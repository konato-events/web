# build should be run from the project root, to be able to copy the Nginx file

FROM konato/php7-beta:latest
MAINTAINER Igor Santos <konato@igorsantos.com.br>
WORKDIR /var/www

# Configures the app
RUN chmod -R 777 storage bootstrap/cache
RUN composer install
RUN mv .env.example .env
RUN php artisan key:generate

# Configures the server
COPY docker/php.ini-development /usr/local/php7/etc/php.ini
COPY config/nginx/konato-dev.conf /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/konato-dev.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default

CMD /usr/bin/supervisord
