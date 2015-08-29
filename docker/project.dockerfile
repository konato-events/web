FROM konato/php7-beta:latest
MAINTAINER Igor Santos <konato@igorsantos.com.br>

# Installs and configures the project
RUN apt-get install wget
RUN wget https://bitbucket.org/konato/web/get/master.tar.gz
RUN tar -xaf master.tar.gz
RUN mv konato-web-* /var/www
WORKDIR /var/www
RUN chmod -R 777 storage bootstrap/cache
RUN composer install
RUN mv .env.example .env
RUN sed -i 's/APP_ENV=local/APP_ENV=prod/g' .env
RUN sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' .env
RUN php artisan key:generate
RUN php artisan route:cache
RUN php artisan config:cache

# Configures the project on Nginx
RUN cp config/nginx/konato-dev.conf /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/konato-dev.conf /etc/nginx/sites-enabled/
RUN rm /etc/nginx/sites-enabled/default
# no need to reload settings since nginx is not yet running

CMD /usr/bin/supervisord
