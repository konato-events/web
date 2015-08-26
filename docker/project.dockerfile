FROM konato/php7-beta:latest
MAINTAINER Igor Santos <konato@igorsantos.com.br>

# Configures the project on Nginx
COPY ../config/nginx/konato-dev.conf /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/konato-dev.conf /etc/nginx/sites-enabled/
RUN service nginx reload; service nginx status

CMD /bin/bash
