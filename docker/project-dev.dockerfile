# build should be run from the project root, to be able to copy the Nginx file

FROM konato/project:base
MAINTAINER Igor Santos <konato@igorsantos.com.br>

WORKDIR /var/www
COPY docker/php.ini-development /usr/local/php7/etc/php.ini
COPY config/nginx/konato-dev.conf /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/konato-dev.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default

CMD /usr/bin/supervisord
