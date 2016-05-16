# build should be run from the project root, to be able to copy the Nginx file

FROM konato/project:base
MAINTAINER Igor Santos <konato@igorsantos.com.br>

# Configures the site
WORKDIR /var/www
COPY docker/php.ini-development /usr/local/php7/etc/php.ini
COPY config/nginx/konato-dev.conf /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/konato-dev.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default

# Configures PostgreSQL to accept connections from external hosts
RUN echo "host all all 172.17.0.1/32 md5" >> /etc/postgresql/9.3/main/pg_hba.conf &&\
    echo "listen_addresses = '*'" >> /etc/postgresql/9.3/main/postgresql.conf

CMD /usr/bin/supervisord
