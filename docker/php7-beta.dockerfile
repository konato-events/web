# Uses the latest Ubuntu base image
FROM ubuntu:latest
MAINTAINER Igor Santos <konato@igorsantos.com.br>

# Silences debconf's endless prattle
ENV DEBIAN_FRONTEND noninteractive

# Adds the official Zend repository
RUN echo "deb http://repos.zend.com/zend-server/early-access/php7/repos ubuntu/" >> /etc/apt/sources.list

# Installs basic stuff
RUN apt-get update && \
	apt-get install  -y --force-yes \
		curl \
		vim

# Installs Nginx and PHP7
RUN apt-get install -y --force-yes \
	nginx \
	php7-beta1 \
	supervisor

# Configures PHP-FPM
COPY usr_local_php7_etc_php-fpm.conf /usr/local/php7/etc/php-fpm.conf
COPY php.ini-development /usr/local/php7/etc
COPY php.ini-production  /usr/local/php7/etc

# Sets Composer variables and the correct PATH
ENV COMPOSER_BINARY /usr/local/bin/composer
ENV COMPOSER_HOME /usr/local/composer
ENV PATH $PATH:$COMPOSER_HOME:/usr/local/php7/bin

# Installs Composer system-wide
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar $COMPOSER_BINARY && \
    chmod +x $COMPOSER_BINARY
RUN mkdir $COMPOSER_HOME && chmod a+rw $COMPOSER_HOME

# Exposes ports that can be used
EXPOSE 80 8080 443

# Configures supervisord
COPY etc_supervisor_conf.d_supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# And finally, starts Nginx and PHP-FPM for your enjoyment
CMD ["/usr/bin/supervisord"]
